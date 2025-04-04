<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง User
        $volunteer = User::create([
            'user_username' => 'volunteer',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'chitdanai',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Volunteer',
        ]);
        $volunteer1 = User::create([
            'user_username' => 'volunteer1@example.com',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'aphinan',
            'province' => '2',
            'user_password' => Hash::make('Pass1234'),
        ]);
        $volunteer2 = User::create([
            'user_username' => 'volunteer2@example.com',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'narich',
            'province' => '3',
            'user_password' => Hash::make('Pass1234'),
        ]);
        $province = User::create([
            'user_username' => 'province@example.com',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'aaa',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
        ]);
        $central = User::create([
            'user_username' => 'central@example.com',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'bbb',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
        ]);

        // กำหนด Role ให้ User
        // $admin->assignRole('admin');
        $volunteer->assignRole('Volunteer');
        $volunteer1->assignRole('Volunteer');
        $volunteer2->assignRole('Volunteer');
        $province->assignRole('Province Officer');
        $central->assignRole('Central Officer');
        // $Province_Officer->assignRole('Province Officer');
        // $Central_Officer->assignRole('Central Officer');
        // $volunteer2->assignRole('Volunteer');
        // $volunteer3->assignRole('Volunteer');


        $province = User::create([
            'user_username' => 'province',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Aphinan Supapol',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Province Officer',
        ]);


        // กำหนด Role ให้ User
        // $admin->assignRole('admin');
        $province->assignRole('Province Officer');

        $central = User::create([
            'user_username' => 'central',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Chanon Srisa',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Central Officer',
        ]);


        // กำหนด Role ให้ User
        // $admin->assignRole('admin');
        $central->assignRole('Central Officer');
    }
}
