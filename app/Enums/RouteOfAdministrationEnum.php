<?php

namespace App\Enums;

enum RouteOfAdministrationEnum: string
{
    case ORAL = 'oral';
    case INTRAVENOUS = 'intravenous';
    case INTRAMUSCULAR = 'intramuscular';
    case SUBCUTANEOUS = 'subcutaneous';
    case TOPICAL = 'topical';
    case INHALATION = 'inhalation';
    case RECTAL = 'rectal';
    case VAGINAL = 'vaginal';

    case OTHER = 'other';
}