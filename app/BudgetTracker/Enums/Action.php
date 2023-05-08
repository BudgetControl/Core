<?php

namespace App\BudgetTracker\Enums;

enum Action : string {
    case Category = 'category';
    case label = 'label';
    case WalletFix = 'wallet_fix';
    case Configurations = 'walletFix_configuration';
}