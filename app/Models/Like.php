<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PostsModel;
use App\Models\User;
use \Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory ;
    protected $table = "likes";

    protected $fillable = ['user_id','post_id'];

    public function post() {
        return $this->belongsTo(PostsModel::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
