<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\postsModel;
use App\Models\chat;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = "users" ;
    protected $fillable = [
        'name',
        'email',
        'password',
        'nickName',
        'image_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts(){
        return $this->hasMany(postsModel::class,'user_id');
    } 

    public function following(){
        return $this->belongsTomany(User::class,'follows','follower_id','followed_id');
    }
    public function followers(){
        return $this->belongsToMany(User::class , 'follows' , 'followed_id', 'follower_id');
    }

    public function messages()
    {
        return $this->hasMany(chat::class);
    }
  

}
