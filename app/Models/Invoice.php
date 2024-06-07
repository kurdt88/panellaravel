<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;


    protected $fillable = ['lease_id', 'property_id', 'subproperty_id', 'sequence', 'ammount', 'iva', 'iva_rate', 'iva_ammount', 'type', 'concept', 'subconcept', 'category', 'start_date', 'due_date', 'comment'];

    protected $appends = ['total', 'balance', 'supplier'];

    public function getTotalAttribute($value)
    {
        $myvalue = $this->ammount + $this->iva_ammount;
        $myvalue = number_format((float) $myvalue, 5, '.', '');

        return ($myvalue);
    }

    public function getBalanceAttribute($value)
    {
        if ($this->category == 'Egreso') {
            $mypayments = $this->expenses->sum('ammount');
            $mypayments = number_format((float) $mypayments, 5, '.', '');
            return ($this->total - $mypayments);

        } else {
            $mypayments = $this->payments->sum('ammount');
            $mypayments = number_format((float) $mypayments, 5, '.', '');
            return ($this->total - $mypayments);

        }

    }


    public function getSupplierAttribute($value)
    {
        if (count($this->expenses) > 0) {

            return Supplier::whereid($this->expenses->first()->supplier_id)->first();

        } else {
            return null;
        }


    }

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }


    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }


    public function expenses()
    {
        return $this->hasMany(Expense::class, 'invoice_id');
    }

}
