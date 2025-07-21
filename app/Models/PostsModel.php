<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostsModel extends Model
{
    protected $table ="posts" ;

    protected $fillable = [
        "user_id",
        "content",
        "image_path",

    ];

    
}
