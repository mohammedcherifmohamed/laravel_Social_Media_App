<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notification';
    protected $fillable = [
        "type",
        "sender_id",
        "receiver_id",
        "is_read"
    ]
}
