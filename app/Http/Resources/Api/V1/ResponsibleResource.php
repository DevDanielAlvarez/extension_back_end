<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "ResponsibleResource",
    description: "Resposta detalhada do responsavel",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Joao Silva"),
        new OA\Property(property: "document_type", type: "string", example: "CPF"),
        new OA\Property(property: "document_number", type: "string", example: "12345678900"),
        new OA\Property(property: "telephone", type: "string", example: "11987654321"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-01-10T12:00:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2026-01-12T08:30:00Z"),
    ]
)]

class ResponsibleResource extends JsonResource
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
            'telephone' => $this->telephone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
