<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Photo;

class Signup extends Authenticatable
{
    use HasFactory;

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }
}
