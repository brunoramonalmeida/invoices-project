<?php

namespace App\Services;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\EmailSenderServiceInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class EmailSenderService implements EmailSenderServiceInterface
{
    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function sendEmail($invoice): void
    {
        $message = sprintf("Cobrança enviada para: %s. Dados para pagamento: %s", $invoice->debt->email, $invoice);
        Log::channel('outputstream')->info($message);
    }
}
