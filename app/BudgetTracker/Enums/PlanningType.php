<?php

namespace App\BudgetTracker\Enums;

enum PlanningType : string {
    case Month = 'monthly';
    case Week = 'weekly';
    case Year = 'yearly';
    case Day = 'daily';
}