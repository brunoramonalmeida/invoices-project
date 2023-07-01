<?php

namespace App\Interfaces;

use App\Models\Debt;

interface DebtServiceInterface
{
    public function generateDebt(Debt $debt): bool;
    public function generateDebts(array $debt): bool;
    public function parseCsvData($csvData): array;
}
