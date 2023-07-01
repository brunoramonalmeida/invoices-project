<?php

namespace Tests\Feature;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\NotificationServiceInterface;
use App\Models\Debt;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $invoiceRepository;
    protected $notificationService;
    protected $invoiceService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->invoiceRepository = $this->app->make(InvoiceRepositoryInterface::class);
        $this->notificationService = $this->app->make(NotificationServiceInterface::class);
        $this->invoiceService = new InvoiceService($this->invoiceRepository, $this->notificationService);
    }

    public function testGenerateInvoiceReturnsInvoice()
    {
        $debt = Debt::factory()->create();

        $invoice = $this->invoiceService->generateInvoice($debt);

        $this->assertInstanceOf(Invoice::class, $invoice);
    }

    public function testGenerateInvoiceReturnsNullForPaidDebt()
    {
        $debt = Debt::factory()->create(['paid' => true]);

        $invoice = $this->invoiceService->generateInvoice($debt);

        $this->assertNull($invoice);
    }

    public function testGenerateInvoiceReturnsExistingInvoice()
    {
        $debt = Debt::factory()->create();
        $existingInvoice = Invoice::factory()->create(['debt_id' => $debt->id]);

        $invoice = $this->invoiceService->generateInvoice($debt);

        $this->assertEquals($existingInvoice->id, $invoice->id);
    }

}
