<?php

namespace App\Dto;

use App\Contracts\IsDto;
use App\Enums\DocumentTypeEnum;
use Carbon\Carbon;

class PatientDto implements IsDto
{
    public function __construct(
        public readonly string $name,
        public readonly DocumentTypeEnum $document_type,
        public readonly string $document_number,
        public readonly Carbon $birthday,
        public readonly string $telephone,
        public readonly string $nursing_assessments,
        public readonly string|null $id // can be null because the patient does not exist yet
    ) {
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'document_type' => $this->document_type,
            'document_number' => $this->document_number,
            'birthday' => $this->birthday,
            'telephone' => $this->telephone,
            'nursing_assessments' => $this->nursing_assessments,
        ];
    }
}