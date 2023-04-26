<?php

namespace App\BudgetTracker\Enums;

enum EntryType : string {
    case Incoming = 'incoming';
    case Expenses = 'expenses';
    case Transfer = 'transfer';
    case Debit = 'debit';
}