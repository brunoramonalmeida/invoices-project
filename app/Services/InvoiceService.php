<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\EmailSenderServiceInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Repositories\DebtRepository;
use App\Models\Debt;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class InvoiceService implements InvoiceServiceInterface
{
    private $invoiceRepository;
    private $emailSenderService;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository, EmailSenderServiceInterface $emailSenderService)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->emailSenderService = $emailSenderService;
    }

    public function generateInvoice(Debt $debt, ?string $due_date = null): ?Invoice
    {
        if (!empty($due_date) && !strtotime($due_date)) {
            throw new \InvalidArgumentException('Invalid date format (correct: Y-m-d)');
        }

        $invoice = Invoice::where('debt_id', $debt->id)->first();
        if ($invoice) {
            return $invoice;
        }

        if (!$debt->paid) {
            $invoice = new Invoice();
            $invoice->amount = $debt->debt_amount;
            $invoice->due_date = $due_date ?? $debt->debt_due_date;
            $invoice->payment_status = Invoice::NOT_PAID;
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
        return null;
    }

    public function generateInvoices(?array $debts = []): bool
    {
        if (!count($debts))
            $debts = Debt::notPaid()->get();
        foreach($debts as $debt) {
            $invoice = $this->generateInvoice($debt);
            if ($invoice) {
                $this->emailSenderService->sendEmail($invoice);
            } else {
                Log::error("Invoice not generated: ".$debt->id);
            }
        }
        return true;
    }

    public function identifyPayment(Invoice $invoice, string $paid_at, float $paid_amount): bool
    {
        if (!empty($due_date) && !strtotime($due_date)) {
            throw new \InvalidArgumentException('Invalid date format (correct: Y-m-d)');
        }

        $invoiceData = Invoice::find($invoice->id);
        $invoiceData->paid_at = $paid_at;
        $invoiceData->paid_amount = $paid_amount;
        $invoiceData->payer_name = $invoiceData->debt->name;
        $invoiceData->payment_status = Invoice::PAID;
        $invoiceData->debt->paid = Debt::PAID;

        return $this->invoiceRepository->save($invoiceData);
    }

}
