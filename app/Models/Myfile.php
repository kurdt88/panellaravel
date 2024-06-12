<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myfile extends Model
{
    use HasFactory;
    protected $fillable = ['file', 'original_name', 'comment', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
