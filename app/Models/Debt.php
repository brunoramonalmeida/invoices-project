<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name', 'governmentId', 'email', 'debtAmount', 'debtDueDate', 'debtId'];
}
