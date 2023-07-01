<?php

namespace App\Interfaces;

interface NotificationServiceInterface
{
    public function sendNotification($invoice): void;
}
