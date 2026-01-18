<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    /** @use HasFactory<\Database\Factories\DrugFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'content_quantity',
        'content_unit',
        'strength',
        'is_coumpounded',
        'route_of_administration',
    ];
}
