<?php
namespace App\BudgetTracker\Interfaces;

interface AccountInterface {

    public function toArray();

    /**
     * Get the value of date
     */ 
    public function getDate();

    /**
     * Get the value of installementValue
     */ 
    public function getInstallementValue();

    /**
     * Get the value of amount
     */ 
    public function getAmount();

    /**
     * Get the value of value
     */ 
    public function getBalance();

    /**
     * Get the value of name
     */ 
    public function getName();
    /**
     * Get the value of color
     */ 
    public function getColor();

    /**
     * Get the value of currency
     */ 
    public function getCurrency();

    /**
     * Get the value of type
     */ 
    public function getType();

    /**
     * Get the value of installement
     */ 
    public function getInstallement();

    public function hash(): string;
    
}