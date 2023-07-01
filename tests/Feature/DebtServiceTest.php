<?php

namespace Tests\Feature;

use App\Interfaces\DebtRepositoryInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Models\Debt;
use App\Services\DebtService;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DebtServiceTest extends TestCase
{
    use RefreshDatabase;

    private $debtRepository;
    private $invoiceService;
    private $debtService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->debtRepository = $this->app->make(DebtRepositoryInterface::class);
        $this->invoiceService = $this->app->make(InvoiceServiceInterface::class);
        $this->debtService = new DebtService($this->debtRepository, $this->invoiceService);
    }

    public function testGenerateDebt()
    {
        $faker = Factory::create();
        $debt = new Debt();
        $debt->fill([
            'name' => $faker->name,
            'government_id' => $faker->numerify('##########'),
            'email' => $faker->email,
            'debt_amount' => $faker->randomFloat(2, 100, 1000),
            'debt_due_date' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
        ]);

        $result = $this->debtService->generateDebt($debt);

        $this->assertTrue($result);
    }

    public function testGenerateDebts()
    {
        $faker = Factory::create();
        $debts = [];

        for ($i = 0; $i < 5; $i++) {
            $debt = new Debt();
            $debt->fill([
                'name' => $faker->name,
                'government_id' => $faker->numerify('##########'),
                'email' => $faker->email,
                'debt_amount' => $faker->randomFloat(2, 100, 1000),
                'debt_due_date' => $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $debts[] = $debt;
        }

        $result = $this->debtService->generateDebts($debts);

        $this->assertTrue($result);
    }

    public function testParseCsvData()
    {
        $faker = Factory::create();
        $csvData = 'name,government_id,email,debt_amount,debt_due_date,debt_id' . "\n";

        $csvLine = [
            $faker->name,
            $faker->numerify('##########'),
            $faker->email,
            $faker->randomFloat(2, 100, 1000),
            $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            $faker->randomNumber(),
        ];
        $csvData .= implode(',', $csvLine) . "\n";

        $result = $this->debtService->parseCsvData($csvData);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(Debt::class, $result[0]);
    }

}
