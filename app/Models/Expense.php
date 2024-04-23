<?php

namespace App\Models;

use App\Models\Expenseimg;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    // protected $fillable = ['lease_id', 'title', 'description', 'ammount', 'image', 'date'];
    protected $fillable = ['lease_id', 'supplier_id', 'invoice_id', 'maintenance_budget', 'rate_exchange', 'ammount_exchange', 'type', 'account_id', 'title', 'description', 'ammount', 'date'];


    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function expenseimgs()
    {
        return $this->hasMany(Expenseimg::class, 'expense_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
