<?php

namespace Database\Factories;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'document_type' => $this->faker->randomElement(DocumentTypeEnum::cases()),
            'document_number' => $this->faker->numerify('###########'),
            'admission_date' => $this->faker->date(),
            'birthday' => $this->faker->date(),
            'telephone' => $this->faker->phoneNumber(),
        ];
    }
}
