<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    /** @use HasFactory<\Database\Factories\ResponsibleFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'document_type',
        'document_number',
        'telephone'
    ];
}
