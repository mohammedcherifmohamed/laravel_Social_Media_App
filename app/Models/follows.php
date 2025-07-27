<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class follows extends Model
{
    protected  $fillable = [
        'follower_id',
        'followed_id',
    
    ];
}
