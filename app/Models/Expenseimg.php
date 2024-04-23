<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenseimg extends Model
{
    use HasFactory;
    protected $fillable = ['expense_id', 'image', 'type', 'original_name'];

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }
}
