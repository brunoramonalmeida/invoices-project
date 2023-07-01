<?php

namespace App\Services;

use App\Interfaces\NotificationServiceInterface;
use Illuminate\Support\Facades\Log;

class EmailNotificationService implements NotificationServiceInterface
{
    public function sendNotification($invoice): void
    {
        $message = sprintf("Cobrança enviada por e-mail para: %s. Dados para pagamento: %s", $invoice->debt->email, $invoice);
        Log::channel('outputstream')->info($message);
    }
}
