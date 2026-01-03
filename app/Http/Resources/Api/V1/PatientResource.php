<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
#[OA\Schema(
    title: "PatientResource",
    description: "Resposta detalhada do paciente",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Maria Silva"),
        new OA\Property(property: "document_type", type: "string", example: "CPF"),
        new OA\Property(property: "document_number", type: "string", example: "12345678900"),
        new OA\Property(property: "birthday", type: "string", format: "date", example: "1990-05-15"),
        new OA\Property(property: "admission_date", type: "string", format: "date", example: "2026-02-20"),
        new OA\Property(property: "telephone", type: "string", example: "11987654321"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2023-10-27T10:00:00Z"),
    ]
)]
class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'document_type' => $this->document_type,
            'document_number' => $this->document_number,
            'birthday' => $this->birthday,
            'admission_date' => $this->admission_date,
            'telephone' => $this->telephone,
            'nursing_assessments' => $this->nursing_assessments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
