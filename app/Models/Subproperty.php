<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subproperty extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'property_id', 'landlord_id', 'type', 'rent', 'address', 'description'];


    public function leases()
    {
        return $this->hasMany(Lease::class, 'subproperty_id');
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class, 'landlord_id');
    }
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

}
