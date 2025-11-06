<?php

namespace Database\Factories;

use App\Models\PostsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostsModelFactory extends Factory
{
    protected $model = PostsModel::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'content' => $this->faker->sentence(),
            'image_path' => 'posts_images/default.png',
            'likes' => 0,
            'created_at'=> now(),
            'updated_at'=> now(),
        ];
    }
}
