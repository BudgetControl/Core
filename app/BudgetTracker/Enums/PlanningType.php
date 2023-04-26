<?php

namespace App\BudgetTracker\Enums;

enum PlanningType : string {
    case Month = 'monthly';
    case Year = 'weekly';
    case Week = 'yearly';
    case Day = 'daily';
}