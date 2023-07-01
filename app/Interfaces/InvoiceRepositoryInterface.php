<?php

namespace App\Interfaces;

use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function save(Invoice $invoices): bool;
}
