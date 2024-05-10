<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'maintenance_budget', 'maintenance_budget_usd', 'description'];



    public function properties()
    {
        return $this->hasMany(Property::class, 'building_id');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'building_id');
    }
}
