<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lease extends Model
{
    use HasFactory;
    protected $fillable = ['property', 'tenant', 'months_grace_period', 'subproperty_id', 'start', 'end', 'iva', 'iva_rate', 'contract', 'rent', 'type', 'deposit'];


    protected $appends = ['propertyname', 'leasependentpayments', 'leasependentexpenses', 'isvalid', 'subpropertyname', 'tenantname', 'propertyowner'];

    public function getPropertynameAttribute($value)
    {


        return Property::whereId($this->property)->first()->title;
    }

    public function getLeasependentpaymentsAttribute($value)
    {
        if ($this->invoices) {
            foreach ($this->invoices as $invoice) {
                if ($invoice->category == 'Ingreso') {
                    if (($invoice->total - $invoice->payments->sum('ammount')) != 0) {
                        return 1;
                    }
                }
            }
        }
        return 0;
    }

    public function getLeasependentexpensesAttribute($value)
    {
        if ($this->invoices) {
            foreach ($this->invoices as $invoice) {
                if ($invoice->category == 'Egreso') {
                    if (($invoice->total - $invoice->expenses->sum('ammount')) != 0) {
                        return 1;
                    }
                }
            }
        }
        return 0;
    }


    public function getIsvalidAttribute($value)
    {

        if ($this->id != 1) {
            if ($this->rescission) {
                // Cancelado
                return 2;
            }
            if (Carbon::createFromFormat('Y-m-d', $this->end)->isPast()) {
                // Vencido
                return 3;
            }
            if (Carbon::createFromFormat('Y-m-d', $this->start)->isFuture()) {
                // Inicia en el Futuro
                return 4;
            }
            if (Carbon::createFromFormat('Y-m-d', $this->end)->subMonths(2)->isPast()) {
                // Vence en menos de 1 mes
                return 5;
            }
        }
        //Valido
        return 1;

    }

    public function getSubpropertynameAttribute($value)
    {
        $mysubproperty = Subproperty::whereId($this->subproperty_id)->first();

        if ($this->subproperty_id == 1) {
            return '--';

        } else {
            return '[' . $mysubproperty->type . '] ' . $mysubproperty->title;
        }
    }

    public function getPropertyownerAttribute($value)
    {


        return Property::whereId($this->property)->first()->landlord->name;
    }
    public function getTenantnameAttribute($value)
    {


        return Tenant::whereId($this->tenant)->first()->name;
    }


    // Relacion con Tenant
    public function tenant_()
    {
        return $this->belongsTo(Tenant::class, 'tenant');
    }

    public function property_()
    {
        return $this->belongsTo(Property::class, 'property');
    }

    public function subproperty()
    {
        return $this->belongsTo(Subproperty::class, 'subproperty_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'lease_id');
    }


    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'lease_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'lease_id');
    }

    public function rescission()
    {
        return $this->hasOne(Rescission::class, 'lease_id');
    }
}
