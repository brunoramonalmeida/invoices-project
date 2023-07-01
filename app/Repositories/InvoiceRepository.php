<?php

namespace App\Repositories;

use App\Interfaces\InvoiceRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function save(Invoice $invoice): void
    {
        $invoice->save();
    }

    public function saveAll(array $invoices): void
    {
        $invoiceData = [];

        foreach ($invoices as $invoice) {
            $invoiceData[] = [
                'id' => $invoice->id,
                'amount' => $invoice->amount,
                'due_date' => $invoice->dueDate,
                'status' => $invoice->status,
                'debt_id' => $invoice->debtId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($invoiceData)) {
            DB::table('invoices')->insert($invoiceData);
        }
    }
}
