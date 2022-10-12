<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Education;
use Illuminate\Database\Seeder;

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
        Education::create([
            'name'=> 'Sekolah Dasar',
        ]);

        Education::create([
            'name'=> 'Sekolah Menengah Pertama',
        ]);

        Education::create([
            'name'=> 'Sekolah Menengah Atas/Kejuruan',
        ]);

        Education::create([
            'name'=> 'Diploma 3 / Sarjana',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'education_id' => '3'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'education_id' => '4'
        ]);

    }
}
