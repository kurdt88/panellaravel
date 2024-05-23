<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Account extends Model
{
    use HasFactory;
    protected $fillable = ['landlord_id', 'alias', 'bank', 'number', 'type', 'comment'];

    protected $appends = ['owner', 'paymentsmonthbalance', 'expensesmonthbalance', 'monthbalance'];

    public function getOwnerAttribute($value)
    {


        return Landlord::whereId($this->landlord_id)->first()->name;
    }

    public function getPaymentsmonthbalanceAttribute($value)
    {


        $now = Carbon::now();

        $payments1 = Payment::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', $this->type)
            ->where('rate_exchange', null)
            ->where('account_id', $this->id)
            ->get();

        $payments2 = Payment::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', $this->type)
            ->whereNotNull('rate_exchange')
            ->where('account_id', $this->id)
            ->get();


        return $payments1->sum('ammount') + $payments2->sum('ammount_exchange');
    }



    public function getExpensesmonthbalanceAttribute($value)
    {


        $now = Carbon::now();


        $expenses1 = Expense::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', $this->type)
            ->where('rate_exchange', null)
            ->where('account_id', $this->id)
            ->get();

        $expenses2 = Expense::whereYear('date', '=', $now->year)
            ->whereMonth('date', '=', $now->month)
            ->where('type', $this->type)
            ->whereNotNull('rate_exchange')
            ->where('account_id', $this->id)
            ->get();


        return $expenses1->sum('ammount') + $expenses2->sum('ammount_exchange');
    }


    public function getMonthbalanceAttribute($value)
    {

        return $this->paymentsmonthbalance - $this->expensesmonthbalance;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'account_id');
    }


    public function expenses()
    {
        return $this->hasMany(Expense::class, 'account_id');
    }


    public function landlord()
    {
        return $this->belongsTo(Landlord::class, 'landlord_id');
    }


}
