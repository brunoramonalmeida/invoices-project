<?php

namespace App\Repositories;

use App\Interfaces\DebtRepositoryInterface;
use App\Models\Debt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DebtRepository implements DebtRepositoryInterface
{
    public function save(Debt $debt): bool
    {
        try {
            if (!empty($debtData)) {
                return $debt->save();
            }
        } catch (\Exception $e) {
            Log::error('Failed to save debt: ' . $e->getMessage());
            return false;
        }

        return true;
    }

    public function saveAll(array $debts): bool
    {
        $debtData = [];

        foreach ($debts as $debt) {
            $debtData[] = [
                'id' => $debt->id,
                'name' => $debt->name,
                'government_id' => $debt->government_id,
                'email' => $debt->email,
                'debt_amount' => $debt->debt_amount,
                'debt_due_date' => $debt->debt_due_date,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        try {
            if (!empty($debtData)) {
                DB::table('debts')->insert($debtData);
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to save debts: ' . $e->getMessage());
            return false;
        }

        return true;
    }
}
