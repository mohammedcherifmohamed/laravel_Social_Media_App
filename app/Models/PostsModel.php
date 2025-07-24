<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\likes;

class PostsModel extends Model
{
    protected $table ="posts" ;

    protected $fillable = [
        "user_id",
        "content",
        "image_path",

    ];
         public function user()
    {
        return $this->belongsTo(User::class);
    }
        public function likes()
    {
        return $this->hasMany(Like::class,'post_id');
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    
}
