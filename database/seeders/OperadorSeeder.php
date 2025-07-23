<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Ana Lopez',
            'email' => 'analopez@example.com',
            'user_name' => 'analopez',
            'role' => 'operador',
            'password' => bcrypt('0000')
    ]);
    }
}
