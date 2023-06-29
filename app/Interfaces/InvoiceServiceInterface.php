<?php

namespace App\Interfaces;

use App\Models\Debt;

interface InvoiceServiceInterface
{
    public function generateInvoice(Debt $debt): void;
}
