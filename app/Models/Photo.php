<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Signup;

class Photo extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(Signup::class);
    }
}
