<?php

namespace App\Interfaces;

use App\Models\Debt;

interface DebtRepositoryInterface
{
    public function save(Debt $debt): bool;
    public function saveAll(array $debts): bool;
}
