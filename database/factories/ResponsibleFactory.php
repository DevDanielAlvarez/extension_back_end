<?php

namespace Database\Factories;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Responsible>
 */
class ResponsibleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'document_type' => $this->faker->randomElement(DocumentTypeEnum::cases()),
            'document_number' => $this->faker->numerify('########'),
            'telephone' => $this->faker->numerify('#############')
        ];
    }
}
