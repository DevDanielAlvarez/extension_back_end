<?php

namespace App\Enums;

enum ContentUnitEnum: string
{
    case CAPSULES = 'capsules';
    case TABLETS = 'tablets';
    case ML = 'ml';
    case MG = 'mg';
    case G = 'g';
    case LITERS = 'liters';
    case UNITS = 'units';
    case OTHER = 'other';
}