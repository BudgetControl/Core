<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Entry as EntryModel;
use App\BudgetTracker\ValueObject\Entries\Entry;
use App\BudgetTracker\Models\Labels;
use DateTime;
use Illuminate\Support\Facades\Log;
use App\Http\Services\UserService;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;


/**
 * Summary of SaveEntryService
 */
class EntryService
{
  const COLORS = [
    "bg-blueGray-200 text-blueGray-600",
    "bg-red-200 text-red-600",
    "bg-orange-200 text-orange-600",
    "bg-amber-200 text-amber-600",
    "bg-teal-200 text-teal-600",
    "bg-lightBlue-200 text-lightBlue-600",
    "bg-indigo-200 text-indigo-600",
    "bg-purple-200 text-purple-600",
    "bg-pink-200 text-pink-600",
    "bg-emerald-200 text-emerald-600 border-white",
  ];

  protected $data;


  /**
   * save a resource
   * @param array $data
   * 
   * @return void
   */
  public function save(array $data): void
  {
    try {

      Log::debug("save entry -- " . json_encode($data));

      $entry = new Entry(
        $data['amount'],
        Currency::findOrFail($data['currency_id']),
        $data['note'],
        SubCategory::findOrFail($data['category_id']),
        Account::findOrFail($data['account_id']),
        PaymentsTypes::findOrFail($data['payment_type']),
        new DateTime($data['date_time']),
        $data['label'],
        $data['confirmed'],
        $data['waranty']
      );

      $entryModel = new EntryModel();
      if (!empty($data['uuid'])) {
        $entryModel = EntryModel::findFromUuid($data['uuid']);
      }

      $entryModel->save($entry->toArray());

      $this->attachLabels($entry->getLabels(), $entryModel);
      if ($data['confirmed'] == 1) {
        AccountsService::updateBalance($entryModel->amount, $entryModel->account_id);
      }
    } catch (\Exception $e) {
      $errorCode = uniqid();
      Log::error("$errorCode " . "Unable save new Entry on entryservice " . $e->getMessage());
      throw new \Exception("Ops an errro occurred " . $errorCode);
    }
  }

  /**
   * read a resource
   * @param int $id of resource
   * 
   * @return object with a resource
   * @throws \Exception
   */
  public static function read(int $id = null): object
  {
    Log::debug("read entry -- $id");
    $result = new \stdClass();

    $entry = EntryModel::withRelations()->user()->orderBy('date_time', 'desc')->where('user_id', UserService::getCacheUserID());

    if ($id === null) {
      $entry = $entry->get();
    } else {
      $entry = $entry->find($id);
    }

    if (!empty($entry)) {
      Log::debug("found entry -- " . $entry->toJson());
      $result = $entry;
    }

    return $result;
  }

  /**
   * save labels data
   * @param array $labels
   * 
   * @return void
   */
  public function attachLabels(array $labels, \Illuminate\Database\Eloquent\Model $model)
  {
    Log::debug("Labels ## " . json_encode($labels));
    if (!empty($labels)) {
      $labelsToSave = [];
      foreach ($labels as $key => $value) {
        if (!empty($value)) {
          if (is_string($value)) {
            $label = Labels::where("name", $value)->first();
          } else {
            $label = Labels::where("id", $value)->first();
          }

          if (empty($label)) {
            $label = new Labels();
            $label->uuid = uniqid();
            $label->name = strtolower($value);
            $label->color = self::COLORS[rand(0, 9)];
            Log::debug("created new label " . $label->name);
            $label->save();
          }
          $labelsToSave[] = $label->id;
        }
      }

      if (!empty($labelsToSave)) {
        Log::debug("Attach new labels " . json_encode($labelsToSave));
        $model->label()->detach();
        foreach ($labelsToSave as $label) {
          $model->label()->attach($label);
        }
      }
    }
  }

  /**
   * generate geolocation object
   * @param string $geoloc
   * 
   * @return string
   */
  protected function geolocation(string $geoloc): string
  {
    $obj = new \stdClass();
    $obj->geoloc = $geoloc;

    return json_encode($obj);
  }

  /**
   * split all data with category type
   * @param \Illuminate\Database\Eloquent\Collection $data 
   * 
   * @return array
   */
  static public function splitEntry_byType(\Illuminate\Database\Eloquent\Collection $data): array
  {
    $returnEntry = [];

    foreach ($data as $entry) {

      foreach (EntryType::cases() as $value) {
        if (strtolower($value->name) == strtolower($entry->type)) {
          $returnEntry[$value->name][] = $entry;
        }
      }
    }

    return $returnEntry;
  }
}
