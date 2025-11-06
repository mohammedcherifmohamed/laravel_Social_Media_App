<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comments;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         for ($i = 6; $i <= 30; $i++) {
            Comments::factory()->create([
                'user_id' => $i,
                'content' => "$i _this is comment {$i}_",
                'post_id' => 22,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
    }
}
