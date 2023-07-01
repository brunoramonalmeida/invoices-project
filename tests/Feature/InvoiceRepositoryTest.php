<?php

namespace Tests\Feature;

use App\Models\Debt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Faker\Factory as Faker;

class InvoiceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private $invoiceRepository;
    private $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->invoiceRepository = new InvoiceRepository();
        $this->faker = Faker::create();
    }

    public function testSave()
    {
        $faker = Faker::create();

        $debt = Debt::factory()->create();

        $invoice = new Invoice();
        $invoice->debt_id = $debt->id;
        $invoice->amount = $faker->randomFloat(2, 100, 1000);
        $invoice->due_date = $faker->date();
        $invoice->payment_status = $faker->randomElement([0, 1]);
        $invoice->beneficiary_name = $faker->name;
        $invoice->beneficiary_document = $faker->numberBetween(10000000000000, 99999999999999);
        $invoice->beneficiary_bank_account = $faker->bankAccountNumber;
        $invoice->payer_name = $faker->name;
        $invoice->payer_document = $faker->numberBetween(10000000000000, 99999999999999);
        $invoice->payer_address = $faker->address;
        $invoice->document_number = $faker->numberBetween(10000000000000, 99999999999999);
        $invoice->paid_at = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s');
        $invoice->paid_amount = $faker->randomFloat(2, 0, $invoice->amount);

        $saved = $this->invoiceRepository->save($invoice);

        $this->assertTrue($saved);
        $this->assertNotNull($invoice->id);
    }
}
