<?php

namespace App\Dto;

use Alvarez\ConcreteDto\AbstractDTO;
use App\Contracts\IsDto;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "ResponsibleDTO",
    description: "DTO to Responsible",
    required: ["name", "document_type", "document_number", "telephone"]
)]
class ResponsibleDTO extends AbstractDTO
{
    public function __construct(
        #[OA\Property(description: "Full name", example: "Joao Silva")]
        public readonly string $name,

        #[OA\Property(description: "Document type", type: "string", example: "CPF")]
        public readonly string $document_type,

        #[OA\Property(description: "Document number", example: "12345678900")]
        public readonly string $document_number,

        #[OA\Property(description: "Contact phone", example: "11987654321")]
        public readonly string $telephone,

        #[OA\Property(description: "Responsible ID", example: 1, nullable: true)]
        public readonly ?string $id = null,

        #[OA\Property(description: "Created at", type: "string", format: "date-time", example: "2026-01-10T12:00:00Z", nullable: true)]
        public readonly ?string $created_at = null,

        #[OA\Property(description: "Updated at", type: "string", format: "date-time", example: "2026-01-12T08:30:00Z", nullable: true)]
        public readonly ?string $updated_at = null,
    ) {
    }
}