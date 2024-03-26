<?php

namespace App\BudgetTracker\Entity\Entries;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use Nette\Schema\ValidationException as NetteException;
use App\BudgetTracker\Models\Payee;
use League\Config\Exception\ValidationException;
use DateTime; 
use stdClass;

class Debit extends Entry {

    protected Payee|null $payee = null;

    public function __construct(
        float $amount,
        Currency $currency,
        string $note,
        DateTime $date_time,
        bool $confirmed,
        Account $account,
        PaymentsTypes $paymentType,
        object $geolocation,
        array $labels,
        Payee $payee,
    ) {

        parent::__construct($amount,EntryType::Expenses,$currency,$note,$date_time,false,false,$confirmed,SubCategory::findOrFail(55),$account,$paymentType,$geolocation,$labels);
        $this->payee = $payee;
        
        $this->validate();
    }

    /**
     * read a resource
     *
     * @return void
     * @throws ValidationException
     */
    private function validate(): void
    {
        if(empty($this->payee)) {
            throw new ValidationException(
                new NetteException('Payee ID must be valid')
            );
        }
    }

    /**
     * Get the value of payee
     */ 
    public function getPayee()
    {
            return $this->payee;
    }
}