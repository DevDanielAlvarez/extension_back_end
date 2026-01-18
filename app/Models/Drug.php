<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ContentUnitEnum;
use App\Enums\RouteOfAdministrationEnum;

class Drug extends Model
{
    /** @use HasFactory<\Database\Factories\DrugFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'content_quantity',
        'content_unit',
        'strength',
        'is_compounded',
        'route_of_administration',
    ];

    protected $casts = [
        'content_unit' => ContentUnitEnum::class,
        'route_of_administration' => RouteOfAdministrationEnum::class,
    ];
}
