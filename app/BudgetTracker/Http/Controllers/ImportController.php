<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Models\Account;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Services\ImportService;

class ImportController extends Controller
{
	private $importService;

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

            if (!empty($request->account)) {
                $import->account = $request->account;
            }

            if (!empty($request->label)) {
                $import->labels = $request->label;
            }

            $import->handle();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->error("Something was wrong during import");
        }
    }

    /**
     * view page for download a csv structure
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function viewCSV()
    {
        $fileName = "template.csv";
        $headerCsv = ImportService::HEADER_CSV;
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($headerCsv) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headerCsv,";");
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }
}
