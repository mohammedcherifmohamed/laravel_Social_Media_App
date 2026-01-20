<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tokens extends Model
{
    protected $table = 'tokens';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
    
}
