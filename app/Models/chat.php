<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    protected $fillable = [
        "message",
        "sender_id",
        "reciever_id",
    ];
protected $table = 'chat';

    


}
