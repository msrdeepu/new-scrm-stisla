<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->name(),
            'name' => fake()->name(),
            'value' => fake()->name(),
            'parent' => fake()->numberBetween(1, 99),
            'dorder' => fake()->numberBetween(1, 99),
            'status' => fake()->name(),

        ];
    }
}
