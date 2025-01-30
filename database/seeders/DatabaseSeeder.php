<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'user_name' => 'testexample',
            'password' => bcrypt('password'),
            'rol' => 'admin',
        ]);
    }
}
