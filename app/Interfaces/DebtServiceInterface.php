<?php

namespace App\Interfaces;

use App\Models\Debt;

interface DebtServiceInterface
{
    public function generateDebt(Debt $debt): void;
    public function generateDebts(array $debt): void;
}
