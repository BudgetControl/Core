<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Entry as EntryModel;
use App\BudgetTracker\Entity\Entries\Entry;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Labels;
use DateTime;
use Illuminate\Support\Facades\Log;
use App\User\Services\UserService;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Models\PaymentsTypes;
use App\Helpers\Helpers;
use Exception;

/**
 * Summary of SaveEntryService
 */
class EntryService
{

  protected $data;
  protected $uuid;

  public function __construct(string $uuid = "")
  {
    $this->uuid = $uuid;
  }


  /**
   * save a resource
   * @param array $data
   * @param EntryType|null $type
   * @param Payee|null $payee
   * 
   * @return void
   */
  public function save(array $data, EntryType $type, Payee|null $payee = null): void
  {
    try {

      Log::debug("save entry -- " . json_encode($data));

      $entry = self::create($data, $type);

      $entryModel = new EntryModel();
      if (!empty($this->uuid)) {
        $entry->setUuid($this->uuid);
        $entryQuery = EntryModel::findFromUuid($this->uuid);
        $entryModel = $entryQuery;
      }

      $entryModel->uuid = $entry->getUuid();
      $entryModel->account_id = $entry->getAccount()->id;
      $entryModel->amount = $entry->getAmount();
      $entryModel->category_id = $entry->getCategory()->id;
      $entryModel->currency_id = $entry->getCurrency()->id;
      $entryModel->date_time = $entry->getDateFormat();
      $entryModel->note = $entry->getNote();
      $entryModel->payment_type = $entry->getPaymentType()->id;
      $entryModel->planned = $entry->getPlanned();
      $entryModel->waranty = $entry->getWaranty();
      $entryModel->confirmed = $entry->getConfirmed();
      $entryModel->type = $entry->getType();

      $walletService = new WalletService(
        EntryService::create($entryModel->toArray(), $entry->getType())
      );

      //TODO: fixme
      if (!is_null($payee)) {
        $entryModel->payee_id = $payee->id;
      }

      $this->attachLabels($entry->getLabels(), $entryModel);
      $walletService->sum();
      
      $entryModel->save();
      
    } catch (\Exception $e) {

      $errorCode = \Ramsey\Uuid\Uuid::uuid4()->toString();;
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
  public function read(string|null $id = null): object
  {
    Log::debug("read entry -- $id");
    $result = new \stdClass();

    $entry = EntryModel::User()->withRelations()->orderBy('date_time', 'desc');

    if ($id === null) {
      $entry = $entry->get();
    } else {
      $entry = $entry->where('uuid', $id)->get();
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
  public static function attachLabels(array $labels, \Illuminate\Database\Eloquent\Model $model)
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
            $label->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();;
            $label->name = strtolower($value);
            $label->color = color();
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
   * revert account wallet if update
   */
  public function revertAccountWallet(): void
  {
    
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

  /**
   * create entity
   */
  public static function create(array $data, EntryType $type): Entry
  {
    $entry = new Entry(
      $data['amount'],
      $type,
      Currency::findOrFail($data['currency_id']),
      $data['note'],
      new DateTime($data['date_time']),
      $data['waranty'],
      empty($data['transfer']) ? false : $data['transfer'],
      $data['confirmed'],
      SubCategory::findOrFail($data['category_id']),
      Account::findOrFail($data['account_id']),
      PaymentsTypes::findOrFail($data['payment_type']),
      new \stdClass(),
      empty($data['label']) ? [] : $data['label']
    );

    if(!empty($data['uuid'])) {
      $entry->setUuid($data['uuid']);
    }

    if(!empty($data['id'])) {
      $entry->setId($data['id']);
    }
    
    return $entry;

  }
}
