<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Year::create(['year_name' => '2021']);
        Year::create(['year_name' => '2022']);
        Year::create(['year_name' => '2023']);
        Year::create(['year_name' => '2024']);
        Year::create(['year_name' => '2025']);
        Year::create(['year_name' => '2026']);
    }
}
