<?php

namespace Database\Factories;

use App\Enums\ContentUnitEnum;
use App\Enums\RouteOfAdministrationEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drug>
 */
class DrugFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'content_quantity' => $this->faker->numberBetween(1, 100),
            'content_unit' => $this->faker->randomElement(ContentUnitEnum::cases()),
            'strength' => $this->faker->word(),
            'is_compounded' => $this->faker->boolean(),
            'route_of_administration' => $this->faker->randomElement(RouteOfAdministrationEnum::cases()),
        ];
    }
}
