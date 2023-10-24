<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class follow_user_table extends Model
{
    use HasFactory;

    protected $fillable = ['follow_user_id'];

    protected $casts = [
        'follow_user_id' => 'array'
    ];
}
