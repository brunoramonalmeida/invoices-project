<?php

namespace App\Interfaces;

interface EmailSenderServiceInterface
{
    public function sendEmail($debt): void;
}
