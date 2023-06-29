<?php

namespace App\Interfaces;

use App\Models\Debt;

interface DebtRepositoryInterface
{
    public function save(Debt $debt): void;
    public function getAll(): array;
}
