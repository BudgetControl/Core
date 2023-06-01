<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Services\EntryService;
use Illuminate\Support\Facades\Log;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Services\ImportService;
use stdClass;

class ImportController extends Controller
{
	private $importService;
	CONST header_export =  [
		'date',
		'amount',
		'note',
		'category',
		'account',
		'installment'
	];

	public function __construct()
	{
	}
	/**
	 *  import function
	 *  @param \Illuminate\Http\Request $request
	 * 
	 *  @return \Illuminate\Http\Response
	 */
	public function import(\Illuminate\Http\Request $request)
	{
		try {

			$request->file->storeAs("import", 'file.csv', "storage");
			$import = new ImportService();

			if (!empty($request->label)) {
				$import->labels = explode(',', $request->label);
			}

			$import->handle();

			return response("All data imported");
		} catch (\Exception $e) {
			Log::error($e->getMessage());
			return response("Something was wrong during import", 500);
		}
	}

	/**
	 *  EXPORT function
	 * 
	 * @return \Symfony\Component\HttpFoundation\StreamedResponse
	 */
	public function export()
	{

			$fileName = "entries.csv";
			$headers = array(
				"Content-type"        => "text/csv",
				"Content-Disposition" => "attachment; filename=$fileName",
				"Pragma"              => "no-cache",
				"Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
				"Expires"             => "0"
			);

			$callback = function () {
				$file = fopen('php://output', 'w');
				fputcsv($file, self::header_export, ";");
				
				$data = EntryService::read();
				foreach ($data as $e) {
					fputcsv($file, $this->build_csv_data($e), ";");
				}
				fclose($file);
			};

			return response()->stream($callback, 200, $headers);
			
	}

	/**
	 * build array to export
	 * @param object $data
	 * 
	 * @return array
	 */
	private function build_csv_data(object $data):array
	{
		try {
			return [
				'date' => $data->date_time,
				'amount' => $data->amount,
				'note' => $data->note,
				'category' => $data->subCategory->name,
				'account' => $data->account->name,
			];
		} catch(\Exception $e) {
			Log::error($e->getMessage());
			return [];
		}
		
	}

	/**
	 * view page for download a csv structure
	 * @return \Symfony\Component\HttpFoundation\StreamedResponse
	 */
	public function viewCSV()
	{
		$fileName = "template.csv";
		$csvHeaders = ImportService::HEADER_CSV;
		$headers = array(
			"Content-type"        => "text/csv",
			"Content-Disposition" => "attachment; filename=$fileName",
			"Pragma"              => "no-cache",
			"Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
			"Expires"             => "0"
		);

		$callback = function () use ($csvHeaders) {
			$file = fopen('php://output', 'w');
			fputcsv($file, $csvHeaders, ";");
			$accounts = Account::all();
			foreach ($accounts as $account) {
				$csv = [
					"currency" => 'eur',
					"amount" => rand(1, 100),
					"note" => '',
					"date" => date('Y-m-d', time()),
					"labels" => '',
					"account" => $account->name
				];
				fputcsv($file, $csv, ";");
			}
			fclose($file);
		};

		return response()->stream($callback, 200, $headers);
	}
}
