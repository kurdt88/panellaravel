<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landlord extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address', 'comment'];


    public function properties()
    {
        return $this->hasMany(Property::class, 'landlord_id');
    }
    public function subproperties()
    {
        return $this->hasMany(Subproperty::class, 'landlord_id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'landlord_id');
    }
}
