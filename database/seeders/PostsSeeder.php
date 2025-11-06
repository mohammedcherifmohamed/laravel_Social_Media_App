<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\PostsModel;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 6; $i <= 30; $i++) {
            PostsModel::factory()->create([
                'user_id' => $i,
                'content' => "$i _this is my_{$i}_post",
                'image_path' => "posts_images/EbOWb8IBLRocJIBcje0gIrOW2bOrDV9JX7BXDjEN.png",
                'likes' => 0 ,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
    }
}
