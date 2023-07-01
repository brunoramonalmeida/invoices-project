<?php

namespace App\Interfaces;

interface PaymentMethod
{
    public function processPayment(array $paymentInfo): bool;
}
