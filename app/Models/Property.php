<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['title', 'location', 'landlord_id', 'building_id', 'description', 'rent'];






    public function leases()
    {
        return $this->hasMany(Lease::class, 'property');
    }


    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function landlord()
    {
        return $this->belongsTo(Landlord::class, 'landlord_id');
    }
    public function subproperties()
    {
        return $this->hasMany(Subproperty::class, 'property_id');
    }
}
