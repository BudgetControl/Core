<?php

namespace App\BudgetTracker\ValueObject\Entries;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\ValueObject\Entries\Entry;
use League\Config\Exception\ValidationException;
use Nette\Schema\ValidationException as NetteException;
use stdClass;
use DateTime;

final class Incoming extends Entry {

    public function __construct(
        float $amount,
        Currency $currency,
        string $note,
        SubCategory $category,
        Account $account,
        PaymentsTypes $paymentType,
        DateTime $date_time,
        array $labels = [],
        bool $confirmed = true,
        bool $waranty = false,
        object $geolocation = new stdClass(),
        bool $transfer = false,
        EntryType $type = EntryType::Incoming,
    ) {

        parent::__construct($amount,$currency,$note,$category,$account,$paymentType,$date_time,$labels,$confirmed,$waranty,$geolocation);

        $this->type = EntryType::Incoming;
        $this->transfer = false;

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
        if($this->amount < 0) {
            throw new ValidationException(
                new NetteException('Amount must be greather than 0')
            );
        }
    }
    
}