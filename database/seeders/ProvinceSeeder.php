<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Provinces;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provinces::create(['pvc_name' => 'Bangkok']);
        Provinces::create(['pvc_name' => 'Samut Prakan']);
        Provinces::create(['pvc_name' => 'Nonthaburi']);
        Provinces::create(['pvc_name' => 'Chonburi']);
    }
}
