<?php

namespace App\BudgetTracker\Entity\Entries;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\Entity\Entries\Entry;
use App\BudgetTracker\Interfaces\EntryInterface;
use League\Config\Exception\ValidationException;
use Nette\Schema\ValidationException as NetteException;
use App\BudgetTracker\Models\Payee;
use stdClass;
use DateTime;

class Incoming extends Entry {

    public function __construct(
        float $amount,
        Currency $currency,
        string $note,
        DateTime $date_time,
        bool $waranty,
        bool $confirmed,
        SubCategory $category,
        Account $account,
        PaymentsTypes $paymentType,
        object $geolocation,
        array $labels,
    ) {

        parent::__construct($amount,EntryType::Incoming,$currency,$note,$date_time,$waranty,false,$confirmed,$category,$account,$paymentType,$geolocation,$labels);
        $this->validate();
    }

    /**
     * validate informations
     * 
     * @return void
     * @throws ValidationException
     */
    private function validate(): void
    {
        if($this->getAmount() < 0) {
            throw new ValidationException(
                new NetteException('Amount must be greather than 0')
            );
        }
    }
    
}