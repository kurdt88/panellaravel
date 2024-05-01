<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;


    protected $fillable = ['lease_id', 'property_id', 'subproperty_id', 'sequence', 'ammount', 'iva', 'iva_rate', 'iva_ammount', 'type', 'concept', 'category', 'start_date', 'due_date', 'comment'];

    protected $appends = ['total', 'supplier'];

    public function getTotalAttribute($value)
    {


        return ($this->ammount + $this->iva_ammount);
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