<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Semester::create([
            'id' => 1,
            'name' => 'Ganjil',
            'description' => 'Ganjil'
        ]);

        \App\Models\Semester::create([
            'id' => 2,
            'name' => 'Genap',
            'description' => 'Genap'
        ]);
    }
}
