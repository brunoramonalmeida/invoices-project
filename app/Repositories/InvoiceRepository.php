<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function save(Invoice $invoice): bool
    {
        try {
            if (!empty($invoice)) {
                $invoice->debt->save();
                return $invoice->save();
            }
        } catch (\Exception $e) {
            Log::error('Failed to save invoice: ' . $e->getMessage());
        }
        return false;
    }

}
