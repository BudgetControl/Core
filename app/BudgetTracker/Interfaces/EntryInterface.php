<?php
namespace App\BudgetTracker\Interfaces;

use League\Config\Exception\ValidationException;
interface EntryInterface {

    /**
     * save a resource
     * @param array $data
     * 
     * @return void
     */
    public function save(array $data) : void;

     /**
     * read a resource
     * @param int $id of resource
     * 
     * @return object with a resource
     * @throws \Exception
     */
    public static function read(int $id) : object;

    /**
     * read a resource
     * @param array $data
     * 
     * @return void
     * @throws ValidationException
     */
    public static function validate(array $data) : void;
    
}