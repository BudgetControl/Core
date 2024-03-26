<?php

namespace App\BudgetTracker\Enums;

enum AccountType : string {
    case Saving = 'Saving';
    case CreditCard = 'Credit Card';
    case CreditCardRevolving = 'Credit Card Revolving';
    case Bank = 'Bank';
    case Cash = 'Cash';
    case Investment = 'Investment';

}