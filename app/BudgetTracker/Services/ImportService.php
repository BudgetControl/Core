<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\AccountType;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Services\CategoryService;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Exceptions\ImportException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
Use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Services\EntryService;
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
    "date",
    "amount",
    "note",
    "category",
    "labels",
    "account",
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
      $data = $this->read(",");

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
   * @throws ImportException
   */
  public function import(array $data)
  {

    try {

      foreach ($data as $key => $value) {

        if ($key != 0 && !empty($value)) {

          $amount = $value[2];

          $dataToCheck = new \DateTime($value[1]);
          $dataToCheck->modify("first day of this month");
          $startTime = $dataToCheck->format('Y-m-d H:m:s');

          $dataToCheck->modify("last day of this month");
          $endTime = $dataToCheck->format('Y-m-d H:m:s');

          $account = Account::where('name',trim($value[6]))->first();
          if(empty($account)) {
            throw new ImportException("No acoount found with name ".$value[6],500);
          }

          $currency = Currency::where("name", strtolower(trim($value[0])))->first();
          if(empty($currency)) {
            throw new ImportException("No currency found with name ".$value[0],500);
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

          $entryService = new EntryService();
          $entry = new stdClass();

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

          $entry->amount = (float) $amount;
          if($account->type == AccountType::CreditCard->value) {
            $entry->amount = (float) $amount * -1;
          }

          $entry->note = $value[3];

          $entry->account_id= $account->id;
          $entry->currency_id = $currency->id;
          $entry->date_time = $value[1] . " 00:00:00";
          $entry->payment_type = 2;
          
          $CategoryService = new CategoryService();
          if(empty($value[4])) {
            $category = $CategoryService->getCategoryIdFromAction($value[3]);
          } else {
            $category = SubCategory::where("name", $value[4])->first()->name;
          }
          Log::debug("Found these category " . $category);

          if ($toupdate === false) {
            $category = SubCategory::where("name", $category)->first();
            $entry->category_id = $category->id;
          }

          $tags = [];
          if (empty($value[5])) {
            $tags = [$CategoryService->getLabelIdFromAction($value[3])];
            Log::debug("Found these labels " . json_encode($tags));
          } else {
            $labels = Labels::whereIn('name',[$value[5]])->get();
            foreach($labels as $label) {
              Log::debug("Found these labels " . $label->name);
              $tags[] = $label->name;
            }
            
          }

          $entry->label = $tags;
          $entry->waranty = 0;
          $entry->transfer = 0;
          $entry->confirmed = 1;

          Log::debug("Store datata ::" . json_encode($entry));
          $type = $amount < 0 ? EntryType::Expenses : EntryType::Incoming;

          $entryService->save((array) $entry, $type);
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
   * @return \App\BudgetTracker\Models\Entry
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
   *  @param \App\BudgetTracker\Models\Entry $data
   * 
   *  @return bool
   */
  protected function checkUpdateData(\App\BudgetTracker\Models\Entry $data, array $value)
  {
    Log::debug("CHECK UPDATE: " . json_encode($data->toArray()));
    $result = false;

    if ($value[2] != $data->amount) {
      Log::debug("Entry update amount with " . $value[2]);
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

}
