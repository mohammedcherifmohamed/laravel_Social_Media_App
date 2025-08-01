<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class chat extends Model
{
    protected $fillable = [
        "message",
        "sender_id",
        "reciever_id",
    ];
    protected $table = 'chat';

      public function user()
    {
        return $this->belongsTo(User::class);
    }


}
