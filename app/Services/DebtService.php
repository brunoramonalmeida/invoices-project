<?php

namespace App\Services;

use App\Interfaces\DebtRepositoryInterface;
use App\Interfaces\DebtServiceInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Models\Debt;

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
        return $this->debtRepository->saveAll($debts);
    }

    public function parseCsvData($csvData): array
    {
        $lines = explode("\n", $csvData);
        $debts = [];

        $lines = array_slice($lines, 1);

        foreach ($lines as $line) {
            $data = str_getcsv($line);

            if (count($data) >= 6) {
                $name = $data[0];
                $governmentId = $data[1];
                $email = $data[2];
                $debtAmount = floatval($data[3]);
                $debtDueDate = $data[4];
                $debtId = intval($data[5]);

                $debt = new Debt();
                $debt->id = $debtId;
                $debt->name = $name;
                $debt->governmentId = $governmentId;
                $debt->email = $email;
                $debt->debtAmount = $debtAmount;
                $debt->debtDueDate = $debtDueDate;
                $debts[] = $debt;
            }
        }

        return $debts;
    }
}
