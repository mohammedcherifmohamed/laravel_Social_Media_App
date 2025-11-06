<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Like;

class LikesSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 6; $i <= 30; $i++) {
            Like::factory()->create([
                'user_id' => $i,
                'post_id' => 27,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
    }
}
