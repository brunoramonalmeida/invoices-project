<?php

namespace Tests\Feature;

use App\Interfaces\DebtRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Debt;
use Faker\Factory;

class DebtRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $debtRepository;
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->debtRepository = $this->app->make(DebtRepositoryInterface::class);
        $this->faker = Factory::create();
    }

    public function testSave()
    {
        $debt = new Debt();
        $debt->name = $this->faker->name;
        $debt->government_id = $this->faker->unique()->randomNumber(8);
        $debt->email = $this->faker->email;
        $debt->debt_amount = $this->faker->randomFloat(2, 100, 1000);
        $debt->debt_due_date = $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d');

        $saved = $this->debtRepository->save($debt);

        $this->assertTrue($saved);
    }

    public function testSaveAll()
    {
        $debts = [];

        for ($i = 0; $i < 2; $i++) {
            $debt = new Debt();
            $debt->name = $this->faker->name;
            $debt->government_id = $this->faker->unique()->randomNumber(8);
            $debt->email = $this->faker->email;
            $debt->debt_amount = $this->faker->randomFloat(2, 100, 1000);
            $debt->debt_due_date = $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d');
            $debts[] = $debt;
        }

        $saved = $this->debtRepository->saveAll($debts);

        $this->assertTrue($saved);
        $this->assertDatabaseCount('debts', 2);
    }
}
