<?php

namespace App\Services;

use App\Models\Debt;
use App\Repositories\InvoicePaymentRepository;

class InvoicePaymentService
{
    private $invoicePaymentRepository;

    public function __construct(InvoicePaymentRepository $invoicePaymentRepository)
    {
        $this->invoicePaymentRepository = $invoicePaymentRepository;
    }

    public function processPayment(array $paymentInfo): bool
    {
        $debtId = $paymentInfo["debtId"];

        if (Debt::findOrFail($debtId)) {
            
        } else {
            // Débito não encontrado
        }

        // Lógica adicional antes de processar o pagamento, se necessário
        $result = $this->invoicePaymentRepository->processPayment($amount);
        // Lógica adicional após o processamento do pagamento, se necessário

        return $result;
    }
}
