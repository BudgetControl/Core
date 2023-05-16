<?php
namespace App\BudgetTracker\Interfaces;

/**
 * 
 * 
 */

interface ImportServiceInterface
{

    /**
     * header validation
     * @param array $header
     * @param array $headerToCheck
     * 
     * @return bool
     */
    public function headerValidation(array $header,array $headerToCheck);

    /**
     * read csv data and convert into array
     * @param string $delimiter
     * 
     * @return array
     */
    public function read(string $delimiter);

    /**
     * import csv to service
     * @param array $data
     * 
     * @return void
     */
    public function import(array $data);

    /**
     * action on and import csv
     * @return void
     */
    public function closeImport();
}