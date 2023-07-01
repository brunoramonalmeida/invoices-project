<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'government_id',
        'email',
        'debt_amount',
        'debt_due_date',
        'paid'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function scopeNotPaid($query)
    {
        return $query->where('paid', 0);
    }
}
