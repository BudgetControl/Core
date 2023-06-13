<?php

namespace App\BudgetTracker\Entity\Entries;


use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Entity\Entries\Entry;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Models\PaymentsTypes;
use DateTime; use stdClass;

final class Transfer extends Entry {

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
        Payee|null $payee = null,
        EntryType $type = EntryType::Debit,
    ) {

        parent::__construct($amount,$currency,$note,$category,$account,$paymentType,$date_time,$labels,$confirmed,$waranty,$geolocation);

        $this->type = EntryType::Transfer;
        $this->transfer = true;
        $this->category = SubCategory::findOrFail(75);

    }
    
}