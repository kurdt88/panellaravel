<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = ['landlord_id', 'alias', 'bank', 'number', 'type', 'comment'];

    protected $appends = ['owner'];

    public function getOwnerAttribute($value)
    {


        return Landlord::whereId($this->landlord_id)->first()->name;
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
