<?php

namespace App\Repositories;

use App\Interfaces\DebtRepositoryInterface;
use App\Models\Debt;

class DebtRepository implements DebtRepositoryInterface
{
    private $debts;

    public function __construct()
    {
        $this->debts = [];
    }

    public function save(Debt $debt): void
    {
        $this->debts[] = $debt;
    }

    public function getAll(): array
    {
        return $this->debts;
    }
}
