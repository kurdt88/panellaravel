<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['lease_id', 'invoice_id', 'account_id', 'concept', 'rate_exchange', 'ammount_exchange', 'type', 'ammount', 'comment', 'date', 'payment_id'];

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
