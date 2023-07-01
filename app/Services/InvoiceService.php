<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\EmailSenderServiceInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Repositories\DebtRepository;
use App\Models\Debt;
use App\Models\Invoice;

class InvoiceService implements InvoiceServiceInterface
{
    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function generateInvoice(Debt $debt, string $due_date): Invoice
    {
        if (!strtotime($due_date)) {
            throw new \InvalidArgumentException('Invalid date format (correct: Y-m-d)');
        }

        $invoice = new Invoice();
        $invoice->amount = $debt->debt_amount;
        $invoice->due_date = $debt->debt_due_date;
        $invoice->payment_status = 0; // CRIAR ENUM
        $invoice->debt_id = $debt->id;
        $invoice->beneficiary_name = "Invoices SA";
        $invoice->beneficiary_document = "99999999999";
        $invoice->beneficiary_bank_account = "12345678";
        $invoice->payer_name = $debt->name;
        $invoice->payer_document = $debt->government_id;
        $invoice->payer_address = "Random Address";
        $invoice->document_number = Helper::gerarCodigoBarras();

        if ($this->invoiceRepository->save($invoice)) {
            return $invoice;
        } else {
            return null;
        }
    }

    public function identifyPayment(Invoice $invoice, string $paid_at, float $paid_amount): void
    {
        $invoiceData = Invoice::find($invoice)->first();
        $invoiceData->paid_at = $paid_at;
        $invoiceData->paid_amount = $paid_amount;
        $invoiceData->payer_name = $invoiceData->debt->name;
        $invoiceData->payment_status = 1;
        $invoiceData->save();
    }

}
