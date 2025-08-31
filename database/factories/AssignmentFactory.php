<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return [
            'title'       => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'due_date'    => $this->faker->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}