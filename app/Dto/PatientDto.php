<?php

namespace App\Dto;

use App\Contracts\IsDto;
use App\Enums\DocumentTypeEnum;
use Carbon\Carbon;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "PatientDto",
    description: "DTO to Patient",
    required: ["name", "document_type", "document_number", "telephone"]
)]
class PatientDto implements IsDto
{
    public function __construct(
        #[OA\Property(description: "Nome completo", example: "Maria Silva")]
        public readonly string $name,

        #[OA\Property(description: "Tipo de documento", type: "string", enum: DocumentTypeEnum::class, example: "CPF")]
        public readonly DocumentTypeEnum $document_type,

        #[OA\Property(description: "Número do documento", example: "12345678900")]
        public readonly string $document_number,

        #[OA\Property(description: "Data de nascimento", type: "string", format: "date", example: "1990-05-15")]
        public readonly Carbon $birthday,

        #[OA\Property(description: "Telefone de contato", example: "11987654321")]
        public readonly string $telephone,

        #[OA\Property(description: "Avaliações de enfermagem", example: ["Paciente estável"])]
        public readonly array $nursing_assessments,

        #[OA\Property(description: 'admission date', example: '2026-02-20')]
        public readonly Carbon $admission_date,

        #[OA\Property(description: "ID do paciente", example: 1, nullable: true)]
        public readonly string|null $id
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
            'admission_date' => $this->admission_date,
            'nursing_assessments' => $this->nursing_assessments,
        ];
    }
}