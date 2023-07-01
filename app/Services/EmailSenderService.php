<?php

namespace App\Services;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\EmailSenderServiceInterface;
use App\Models\Invoice;

class EmailSenderService implements EmailSenderServiceInterface
{
    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function sendEmail($invoice): void
    {
        var_dump("Cobrança enviada para: ".$invoice);
    }
}
