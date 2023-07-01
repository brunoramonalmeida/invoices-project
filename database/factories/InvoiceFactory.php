<?php

namespace Database\Factories;

use App\Models\Debt;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'debt_id' => Debt::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'due_date' => $this->faker->date(),
            'payment_status' => $this->faker->randomElement([Invoice::NOT_PAID, Invoice::PAID]),
            'beneficiary_name' => $this->faker->company,
            'beneficiary_document' => $this->faker->unique()->randomNumber(6),
            'beneficiary_bank_account' => $this->faker->bankAccountNumber,
            'payer_name' => $this->faker->name,
            'payer_document' => $this->faker->unique()->randomNumber(6),
            'payer_address' => $this->faker->address,
            'document_number' => $this->faker->randomNumber(8),
            'paid_at' => $this->faker->dateTime(),
            'paid_amount' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
