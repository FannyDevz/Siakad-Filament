<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create([
            'id' => 1,
            'name' => 'Admin',
            'description' => 'Admin Role'
        ]);

        \App\Models\Role::create([
            'id' => 2,
            'name' => 'Teacher',
            'description' => 'Teacher Role'
        ]);

        \App\Models\Role::create([
            'id' => 3,
            'name' => 'Student',
            'description' => 'Student Role'
        ]);
    }
}
