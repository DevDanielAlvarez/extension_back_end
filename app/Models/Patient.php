<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'document_type',
        'document_number',
        'admission_date',
        'birthday',
        'telephone',
        'nursing_assessments'
    ];

    protected $casts = [
        'nursing_assessments' => 'array',
        'document_type' => DocumentTypeEnum::class,
    ];

    public function responsibles(): BelongsToMany
    {
        return $this->belongsToMany(Responsible::class, )->withTimestamps();
    }
}
