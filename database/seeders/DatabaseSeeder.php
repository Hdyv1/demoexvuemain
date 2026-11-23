<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'fullname' => 'admin',
            'username' => 'Conf2027',
            'role' => 'admin',
            'phonenumber' => '79123456789',
            'email' => 'admin@admin',
            'password' => 'Demo77',
        ]);
    }
}
