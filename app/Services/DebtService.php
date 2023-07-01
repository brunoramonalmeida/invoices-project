<?php

namespace App\Services;

use App\Interfaces\DebtRepositoryInterface;
use App\Interfaces\DebtServiceInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Models\Debt;
use Illuminate\Support\Facades\DB;

class DebtService implements DebtServiceInterface
{
    private $debtRepository;
    private $invoiceService;

    public function __construct(DebtRepositoryInterface $debtRepository, InvoiceServiceInterface $invoiceService)
    {
        $this->debtRepository = $debtRepository;
        $this->invoiceService = $invoiceService;
    }

    public function generateDebt(Debt $debt): bool
    {
        return $this->debtRepository->save($debt);
    }

    public function generateDebts(array $debts): bool
    {
        return DB::transaction(function () use ($debts) {
            $this->debtRepository->saveAll($debts);
            $this->invoiceService->generateInvoices($debts);
            return true;
        });
    }

    public function parseCsvData($csvData): array
    {
        $lines = explode("\n", $csvData);
        $debts = [];

        $lines = array_slice($lines, 1);

        foreach ($lines as $line) {
            $data = str_getcsv($line);

            if (count($data) >= 6) {
                $attributes = [
                    'id' => intval($data[5]),
                    'name' => $data[0],
                    'government_id' => $data[1],
                    'email' => $data[2],
                    'debt_amount' => floatval($data[3]),
                    'debt_due_date' => $data[4],
                ];

                $debt = new Debt();
                $debt->fill($attributes);
                $debts[] = $debt;
            }
        }

        return $debts;
    }
}
