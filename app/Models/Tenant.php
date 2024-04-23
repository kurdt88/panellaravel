<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'address', 'picture', 'description', 'email', 'phone'];

    // Relacion con Leases
    public function leases()
    {
        return $this->hasMany(Lease::class, 'tenant');
    }
}
