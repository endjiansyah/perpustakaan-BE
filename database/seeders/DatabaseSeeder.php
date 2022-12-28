<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::query()->create([
            "name" => "hilih",
            "email" => "hilih@gmail.com",
            "password" => "hilih",
            "email_verified_at" => now(),
            "remember_token" => Str::random(10)
        ]);
        $this->call(RatingSeeder::class);
    }
}
