<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    protected $fillable = ['building_id', 'year', 'month', 'comment', 'maintenance_budget_mxn', 'maintenance_budget_usd', 'comment'];


    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

}
