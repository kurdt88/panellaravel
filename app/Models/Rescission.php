<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rescission extends Model
{
    use HasFactory;
    protected $fillable = ['lease_id', 'date_start', 'reason'];

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id');
    }

}
