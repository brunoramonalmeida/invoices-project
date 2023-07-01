<?php

namespace App\Repositories;

class InvoicePaymentRepository
{
    public function processPayment(float $amount): bool
    {
        // Lógica específica para processar o pagamento por boleto
        // ...

        return true; // Exemplo de retorno bem-sucedido
    }
}
