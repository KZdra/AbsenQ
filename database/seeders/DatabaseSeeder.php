<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'created_at' => now()
        ]);
        User::create([
            'name' => 'piket',
            'username' => 'piket',
            'password' => Hash::make('piket'),
            'role' => 'piket',
            'created_at' => now()

        ]);
    }
}
