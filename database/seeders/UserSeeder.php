<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Hugo Navarro',
            'email' => 'hugo@example.com',
            'user_name' => 'hugonavarro',
            'role' => 'admin',
            'password' => bcrypt('0000')
    ]);

    }
}
