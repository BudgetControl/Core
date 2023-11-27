<?php

namespace App\Exchange\Services;

use \BenMajor\ExchangeRatesAPI\ExchangeRatesAPI;
use \BenMajor\ExchangeRatesAPI\Response;
use \BenMajor\ExchangeRatesAPI\Exception;

class ExchangeService
{

    private ExchangeRatesAPI $api;

    private function __construct()
    {
        $access_key = env('EXC_API_KEY','eacd458f6f0ee03b67f03aa735b19023');

        if(empty($access_key)) {
            throw new Exception("No API key found, please configure your enviroment");
        }

        $use_ssl = false; # Free plans are restricted to non-SSL only.
        $this->api = new ExchangeRatesAPI($access_key, $use_ssl);
    }

    public static function init()
    {
        return new self();
    }

    public function fetch(): string
    {
        return $this->api->fetch(true);
    }

    /**
     * Retrieves the exchange rate for a specific currency, or returns the exchange rate if only one rate is present in the response.
     * @param string $currency
     * 
     * @return string
     */
    public function getRate(string $currency): string
    {
        return $this->api->fetch()->getRate($currency);
    }
    
    /**
     * By default, the base currency is set to Euro (EUR), but it can be changed
     * @param string $value
     * @return self
     */
    public function setBaseCurrency(string $value = 'EUR'): self
    {
        $this->validateCurrency($value);
        $this->api->setBaseCurrency($value);
        return $this;
    }

    /**
     * If you do not want all current rates, it's possible to specify only the currencies you want using addRate().
     * The following code fetches only the exchange rate between GBP and EUR:
     * @param string $value
     * @return self
     */
    public function fetchSpecificRates(string $rate, string $baseCurrency = 'EUR'): self
    {
        $this->validateCurrency($rate);
        $this->validateCurrency($baseCurrency);
        $this->api->addRate($rate)->setBaseCurrency($baseCurrency);
        return $this;
    }

    private function validateCurrency(string $value): void
    {
        $currency = file_get_contents(__DIR__.'/../../../database/sql/currency.json');
        $currency = (array) json_decode($currency, true);

        // if(!in_array($value,$currency)) {
        //     throw new Exception("$value is not a valid currency");
        // }

    }

}
