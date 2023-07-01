<?php

namespace App\Interfaces;

use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function save(Invoice $invoices): void;
    public function saveAll(array $invoices): void;
}
