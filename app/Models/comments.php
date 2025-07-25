<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class comments extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    public function user(){
        return $this->belongsTo(user::class,'user_id');
    }
}
