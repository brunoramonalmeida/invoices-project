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

    public function generateDebt(Debt $debt): void
    {
        $this->debtRepository->save($debt);
    }

    public function generateDebts(array $debts): void
    {
        $this->debtRepository->saveAll($debts);
    }

    // public function settleDebt(Debt $debt): void
    // {
    //     $invoices = $debt->invoices()->get();
    //     foreach ($invoices as $invoice) {
    //         $this->invoiceService->identifyPayment($invoice);
    //     }
    // }
}
