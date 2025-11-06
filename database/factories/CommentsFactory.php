<?php

namespace Database\Factories;

use App\Models\Comments;  // the actual model class
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsFactory extends Factory
{
    protected $model = Comments::class;  // important!

    public function definition(): array
    {
        return [
            'user_id' => 1,
            'post_id' => 1,
            'content' => $this->faker->sentence(), // generate random content
            'created_at'=> now(),
            'updated_at'=> now(),
        ];
    }
}
