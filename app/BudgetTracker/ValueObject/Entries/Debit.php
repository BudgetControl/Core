<?php

namespace App\BudgetTracker\ValueObject;

use App\BudgetTracker\Enums\EntryType;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\ValueObject\Entries\Entry;
use Illuminate\Support\Facades\Validator;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use DateTime; use stdClass;
final class Debit extends Entry {

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
        EntryType $type = EntryType::Debit,
    ) {

        parent::__construct($amount,$currency,$note,$category,$account,$paymentType,$date_time,$labels,$confirmed,$waranty,$geolocation);

        $this->type = EntryType::Debit;
        $this->transfer = false;

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
        $rules = [
            'payee_id' => 'string'
        ];

        Validator::validate($this->toArray(), $rules);
    }
    
}