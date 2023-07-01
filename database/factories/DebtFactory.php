<?php

namespace Database\Factories;

use App\Models\Debt;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebtFactory extends Factory
{
    protected $model = Debt::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'government_id' => $this->faker->unique()->randomNumber(6),
            'email' => $this->faker->email,
            'debt_amount' => $this->faker->randomFloat(2, 100, 1000),
            'debt_due_date' => $this->faker->date(),
            'paid' => false,
        ];
    }
}
