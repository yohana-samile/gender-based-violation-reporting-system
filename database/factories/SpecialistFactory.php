<?php

namespace Database\Factories;

use App\Models\Specialist;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialistFactory extends Factory
{
    protected $model = Specialist::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->jobTitle,
            'description' => $this->faker->paragraph,
        ];
    }
}
