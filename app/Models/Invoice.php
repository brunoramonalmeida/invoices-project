<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public const NOT_PAID = 0;
    public const PAID = 1;
    public const EXPIRED = 2;

    protected $fillable = [
        'debt_id',
        'amount',
        'due_date',
        'payment_status',
        'beneficiary_name',
        'beneficiary_document',
        'beneficiary_bank_account',
        'payer_name',
        'payer_document',
        'payer_address',
        'document_number',
        'paid_at',
        'paid_amount',
    ];

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
