<?php

namespace App\Repositories;

use App\Interfaces\DebtRepositoryInterface;
use App\Models\Debt;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DebtRepository implements DebtRepositoryInterface
{
    public function save(Debt $debt): void
    {
        $debt->save();
    }

    public function saveAll(array $debts): void
    {
        $debtData = [];

        foreach ($debts as $debt) {
            $debtData[] = [
                'id' => $debt->id,
                'name' => $debt->name,
                'government_id' => $debt->governmentId,
                'email' => $debt->email,
                'debt_amount' => $debt->debtAmount,
                'debt_due_date' => $debt->debtDueDate,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($debtData)) {
            DB::table('debts')->insert($debtData);
        }
    }
}
