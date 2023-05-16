<?php

namespace App\BudgetTracker\Services;

use App\Http\Services\CategoryService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Interfaces\ImportServiceInterface;
use Exception;
use stdClass;

//
class ImportService implements ImportServiceInterface
{
  public int $account;
  public array $labels = [];

  const HEADER_CSV = [
    "currency",
    "amount",
    "note",
    "date",
    "labels",
  ];

  public $filePath = null;
  private $file_handle;

  /* @var \App\Models\Entry */
  private $items = null;

  /**
   * handle import function
   * @return void
   * @throws Exception
   */
  public function handle()
  {

    $file = $this->getLastFile();
    if (!empty($file)) {
      $this->filePath = storage_path($file);
      Log::debug($file);

      $this->getLastItem();
      $data = $this->read(";");

      if ($data !== false) {
        Log::debug("import " . json_encode($data));
        $this->import($data);
      }

      $this->closeImport();
    } else {
      Log::error("Unable to find any file");
      throw new Exception("Unable to find a file");
    }
  }

  /**
   * Convert CSV into ARRAY
   * @param string $delimiter
   * 
   * @return array
   * @throws Exception
   */
  public function read(string $delimiter)
  {
    $this->file_handle = fopen($this->filePath, 'r');
    while (!feof($this->file_handle)) {
      $line_of_text[] = fgetcsv($this->file_handle, 0, $delimiter);
    }
    //check if file header is correct
    if ($this->headerValidation(self::HEADER_CSV, $line_of_text[0]) === false) {
      throw new Exception('Header CSV is not correct');
    }

    return $line_of_text;
  }

  /**
   * import csv to service
   * @param array $data
   * 
   * @return void
   * @throws Exception
   */
  public function import(array $data)
  {

    try {

      foreach ($data as $key => $value) {

        if ($key != 0 && !empty($value)) {

          $amount = $value[1];

          $dataToCheck = new \DateTime($value[3]);
          $dataToCheck->modify("first day of this month");
          $startTime = $dataToCheck->format('Y-m-d');

          $dataToCheck->modify("last day of this month");
          $endTime = $dataToCheck->format('Y-m-d');

          $account = Account::find($this->account);
          $currency = Currency::where("name", strtolower($value[0]))->first();

          if (empty($account)) {
            $account = new Account();
            $account->uuid = uniqid();
            $account->name = "new-" . uniqid();
            $account->save();
            Log::debug("created new account " . $account->uuid);
          }

          if (empty($currency)) {
            $currency = new Currency();
            $currency->uuid = uniqid();
            $currency->name = strtolower($value[0]);
            $currency->save();
            Log::debug("created new currency " . $currency->uuid);
          }

          Log::debug("Check if these entry exist");
          Log::debug("----" . json_encode($value));

          $entryExist = Entry::where('amount', $amount)
            ->where('account_id', $account->id)
            ->where('date_time', '>=', strTotime($startTime))
            ->where('date_time', '<=', strTotime($endTime))
            ->with('account')->with('label')->with('currency')->with('subCategory.category')->first();

          $not_exist = empty($entryExist);
          $toupdate = false;

          $entry = new Entry();

          if ($not_exist === true) {
            Log::debug("Entry not exist");
          } else {
            Log::debug("Entry exist");
            Log::debug("-------" . json_encode($entryExist->toArray()));
            //get entry to update
            $entry->id = $entryExist->id;
            $entry->category = $entryExist->category_id;
            $toupdate = $this->checkUpdateData($entryExist, $value);
          }

          $entry->amount = $entry->cleanAmount($amount);
          $entry->type = $amount <= 0 ? "expenses" : "incoming";
          $entry->confirmed = 1;
          $entry->note = $value[2];
          $entry->transfer = 0;
          $entry->planned = 0;
          $entry->payment_type = 1;

          $entry->account = $account->id;
          $entry->currency = $currency->id;

          $date = $this->checkDateFormat($value[3]);

          if ($date === '') {
            Log::warning("Ivalid date format " . $value[3]);
            $date = new \DateTime();
          }

          $date = $date->format("Y-m-d H:i:s");
          $entry->created_at = $date;

          $CategoryService = new CategoryService();
          $category = $CategoryService->getCategoryIdFromAction($value[2]);
          Log::debug("Found these category " . $category);

          if ($toupdate === false) {
            $category = SubCategory::where("name", $category)->first();
            $entry->category = $category->id;
          }

          if (empty($this->labels)) {
            $tags = $CategoryService->getLabelIdFromAction($value[2]);
            Log::debug("Found these labels " . json_encode($tags));
          } else {
            $tags = $this->labels;
          }

          $tags = explode("|", $tags);
          $entry->label = $tags;

          Log::debug("Store datata ::" . json_encode($entry->toArray()));

          $entry->save();
          Log::info("Insert data");
        }
      }
    } catch (Exception $e) {
      Log::critical($e->getMessage());
      throw new Exception($e->getMessage());
    }
  }

  /**
   * get last item
   *
   * @return \App\Models\Entry
   */
  private function getLastItem()
  {
    if (empty($this->items)) {
      $entry = DB::table('entries')->orderBy('date_time', 'desc')->first();
      $this->items = $entry;
    }
    return $this->items;
  }

  /**
   * check if date is passed
   * @param string $date
   * @param string $fromDate
   * @return bool
   */
  protected function checkPassedDate(string $date, string $fromDate = null)
  {
    //check if is a new data
    $datex = strtotime($date);
    $now = empty($fromDate) ? time() : strtotime($fromDate);
    if ($datex < $now) {
      return false;
    }
    return true;
  }

  /**
   * return last file
   * @return string
   */
  private function getLastFile()
  {
    $files = Storage::disk("storage")->files('import');
    return end($files);
  }

  /**
   * check if need an update
   *  @param \App\Models\Entry $data
   * 
   *  @return bool
   */
  protected function checkUpdateData(\App\BudgetTracker\Models\Entry $data, array $value)
  {
    Log::debug("CHECK UPDATE: " . json_encode($data->toArray()));
    $result = false;

    if ($value[1] != $data->amount) {
      Log::debug("Entry update amount with " . $value[1]);
      $result = true;
    }

    if ($this->account != $data->account->id) {
      Log::debug("Entry update account with " . $this->account);
      $result = true;
    }

    if ($value[0] != $data->currency->name) {
      Log::debug("Entry update currency with " . $value[0]);
      $result = true;
    }

    if ($value[2] != $data->note) {
      Log::debug("Entry update note with " . $value[2]);
      $result = true;
    }

    return $result;
  }


  /**
   * header validation
   *
   * @param array $header
   * @param array $headerToCheck
   * @return bool
   */
  public function headerValidation(array $header, array $headerToCheck)
  {
    foreach ($headerToCheck as $key => $value) {
      if (!in_array($value, $header)) {
        Log::warning("Header csv is not correct missing " . $value);
        return false;
      }
    }
    return true;
  }

  /**
   * action on and import csv
   * @return void
   */
  public function closeImport()
  {
    fclose($this->file_handle);
    unlink($this->filePath);
    Log::info("Flush import cache");
    Log::info("Finish process ####");

    Log::info("Close import ##");
  }

  /**
   * check the right date format
   * @param string $dateTime
   * 
   * @return string with date
   */
  private function checkDateFormat(string $dateTime)
  {
    $result = '';
    $formats = [
      'd-m-Y',
      'm/d/Y'
    ];

    foreach ($formats as $format) {
      $entryDate = new \DateTime();
      $date = $entryDate->createFromFormat($format, $dateTime);

      if ($date !== false) {
        $result = $date;
      }
    }

    return $result;
  }
}
