<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Todo> */
class TodoFactory extends Factory
{
    protected $model = Todo::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph(),
            'due_date' => $this->faker->date(),
            'is_completed' => false,
        ];
    }
}
