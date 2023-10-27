<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower_count extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    protected $casts = [
        'user_id' => 'array'
    ];
}
