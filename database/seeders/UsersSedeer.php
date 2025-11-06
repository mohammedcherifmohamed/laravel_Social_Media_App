<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;

class UsersSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 30;

        for ($i = 1; $i <= $count; $i++) {
            User::factory()->create([
                'password' => Hash::make('aze'),
                'email' => "user{$i}@gmail.com",
                'name' => "user_{$i}",
                'nickName' => "user_{$i}",
                'image_path'=> "profile_images/cTKDkJeahSkrZAklM4GTUud8S8aMucgG4jbHbG5T.jpg",
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }
    }
}
