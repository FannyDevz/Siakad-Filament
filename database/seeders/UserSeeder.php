<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => '1'
        ]);

        \App\Models\User::create([
            'name' => 'Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role_id' => '2'
        ]);

        \App\Models\User::create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role_id' => '3'
        ]);
    }
}
