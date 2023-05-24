<?php

namespace App\BudgetTracker\Enums;

enum AccountType : string {
    case Debit = 'Debit';
    case Saving = 'Saving';
    case CreditCard = 'Credit Card';
    case Bank = 'Bank';
}