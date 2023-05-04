<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Models\Labels;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;

/**
 * Summary of SaveEntryService
 */
class EntryService extends Math\EntriesMath implements EntryInterface
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

  function __construct()
  {
    $this->data = Entry::withRelations()->orderBy('date_time', 'desc');
  }

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

      self::validate($data);
      $entry = new Incoming();
      if (!empty($data['uuid'])) {
        $entry = Incoming::findFromUuid($data['uuid']);
      }

      foreach ($data as $k => $v) {
        if ($k !== 'label') {
          $entry->$k = $v;
        }
      }

      $entry->planned = $this->isPlanning(new \DateTime($entry->date_time));

      $entry->save();
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

    $entry = Entry::withRelations()->orderBy('date_time', 'desc');

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
   * set data to start stats
   * @param string $date
   * 
   * @return self
   */
  public function setDateStart(string $date): self
  {
    $date = new DateTime($date);
    $this->data->where('date_time', '>=', $date->getTimestamp());
    return $this;
  }

  /**
   * set data to start stats
   * @param string $date
   * 
   * @return self
   */
  public function setDateEnd(string $date): self
  {
    $date = new DateTime($date);
    $this->data->where('date_time', '<=', $date->getTimestamp());
    return $this;
  }

  /**
   * set data to start stats
   * @param bool $date
   * 
   * @return self
   */
  public function setPlanning(bool $planning): self
  {
    $this->data->where('planned', $planning);
    return $this;
  }

  /**
   * set data to start stats
   * @param string $column
   * @param string|int $value
   * 
   * @return self
   */
  public function addConditions(string $column, string|int $value): self
  {
    $this->data->where($column, $value);
    return $this;
  }


    /** 
     * chek if is planned entry
     * @param DateTime $dateTime
     * 
     * @return bool
     */
    protected function isPlanning(DateTime $dateTime): bool
    {
        $today = new \DateTime();
        if ($dateTime->getTimestamp() > $today->getTimestamp()) {
            return true;
        }

    return false;
  }

  /**
   * retrive data
   * 
   * @return Entry
   */
  public function get()
  { 
    return $this->data->get();
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
   * read a resource
   *
   * @param array $data
   * @return void
   * @throws ValidationException
   */
  public static function validate(array $data): void
  {
    $rules = [
      'id' => ['integer'],
      'date_time' => ['date', 'date_format:Y-m-d H:i:s', 'required'],
      'amount' => ['required', 'numeric', 'gte:0'],
      'note' => 'nullable',
      'waranty' => 'boolean',
      'transfer' => 'boolean',
      'confirmed' => 'boolean',
      'planned' => 'boolean',
      'category_id' => ['required', 'integer'],
      'account_id' => ['required', 'integer'],
      'currency_id' => 'required|boolean',
      'payment_type' => ['required', 'integer'],
      'geolocation_id' => 'integer'
    ];

    Validator::validate($data, $rules);
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
