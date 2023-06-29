<?php

namespace App\Interfaces;

use App\Models\Debt;

interface EmailSenderServiceInterface
{
    public function sendEmail(Debt $debt): void;
}
