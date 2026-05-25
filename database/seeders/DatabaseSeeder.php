<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\PeminjamanTestSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (DEMO)
        User::updateOrCreate(
            ['email' => 'admin@perpus.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        //User (DEMO)
         User::updateOrCreate(
            ['email' => 'user@perpus.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
            ]
        );

        $this->call(PeminjamanTestSeeder::class);
    }
}