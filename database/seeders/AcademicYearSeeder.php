<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AcademicYear::create([
            'id' => 1,
            'name' => '2022/2023',
            'start_date' => '2022-08-01',
            'end_date' => '2023-06-30',
        ]);

        \App\Models\AcademicYear::create([
            'id' => 2,
            'name' => '2023/2024',
            'start_date' => '2023-08-01',
            'end_date' => '2024-06-30',
        ]);

        \App\Models\AcademicYear::create([
            'id' => 3,
            'name' => '2024/2025',
            'start_date' => '2024-08-01',
            'end_date' => '2025-06-30',
        ]);
    }
}
