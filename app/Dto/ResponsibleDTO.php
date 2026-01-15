<?php

namespace App\Dto;

use Alvarez\ConcreteDto\AbstractDTO;
use App\Contracts\IsDto;

class ResponsibleDTO extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $document_type,
        public readonly string $document_number,
        public readonly string $telephone,
        public readonly ?string $id = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
    ) {
    }
}