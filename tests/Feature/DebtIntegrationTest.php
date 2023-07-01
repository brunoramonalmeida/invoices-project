<?php

namespace Tests\Feature;

use App\Interfaces\DebtRepositoryInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Models\Debt;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Services\DebtService;
use App\Services\EmailNotificationService;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class DebtIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private $debtRepository;
    private $invoiceService;
    private $debtService;
    private $notificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->debtRepository = $this->app->make(DebtRepositoryInterface::class);
        $this->invoiceService = $this->app->make(InvoiceServiceInterface::class);
        $this->notificationService = $this->app->make(NotificationServiceInterface::class);
        $this->debtService = new DebtService($this->debtRepository, $this->invoiceService);
    }

    public function testCreateDebtGenerateInvoiceAndSendEmail()
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

        $debtResult = $this->debtService->generateDebt($debt);

        $this->assertTrue($debtResult);

        $gen = $this->invoiceService->generateInvoices();

        $this->assertTrue($gen);

    }
}

