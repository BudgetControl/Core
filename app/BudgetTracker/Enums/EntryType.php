<?php

namespace App\BudgetTracker\Enums;

use Illuminate\Contracts\Queue\EntityNotFoundException;

enum EntryType : string {
    case Incoming = 'incoming';
    case Expenses = 'expenses';
    case Transfer = 'transfer';
    case Debit = 'debit';
    case Investments = 'investments';

    public static function where(string $type): EntryType
    {
        foreach(EntryType::cases() as $case) {
            if($case->value == $type) {
                return $case;
            }
        }

        throw new EntityNotFoundException("Entity $type is not valid",500);
    }
}