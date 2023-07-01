<?php

namespace App\Interfaces;

use App\Models\Debt;
use App\Models\Invoice;

interface InvoiceServiceInterface
{
    public function generateInvoice(Debt $debt, string $due_date): ?Invoice;
    public function generateInvoices(): bool;
    public function identifyPayment(Invoice $invoice, string $paid_at, float $paid_amount): bool;
}
