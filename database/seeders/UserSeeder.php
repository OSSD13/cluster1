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
            'user_fullname' => 'Chitdanai Rattanathianthong',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Volunteer',
        ]);
        $volunteer1 = User::create([
            'user_username' => 'volunteer1',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Aphinan Supapol',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
        ]);
        $volunteer2 = User::create([
            'user_username' => 'volunteer2',
            'user_name_title' => 'Miss.',
            'user_fullname' => 'Tikamporn Boonyawat',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
        ]);
        $volunteer3 = User::create([
            'user_username' => 'volunteer3',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Narich Pradit',
            'province' => '2',
            'user_password' => Hash::make('Pass1234'),
        ]);
        $volunteer4 = User::create([
            'user_username' => 'volunteer4',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Thanaphoom Somkhane',
            'province' => '2',
            'user_password' => Hash::make('Pass1234'),
        ]);
        $volunteer5 = User::create([
            'user_username' => 'volunteer5',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Chanon Srisa',
            'province' => '3',
            'user_password' => Hash::make('Pass1234'),
        ]);

        $volunteer->assignRole('Volunteer');
        $volunteer1->assignRole('Volunteer');
        $volunteer2->assignRole('Volunteer');
        $volunteer3->assignRole('Volunteer');
        $volunteer4->assignRole('Volunteer');
        $volunteer5->assignRole('Volunteer');



        $province = User::create([
            'user_username' => 'province',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Province Officer 1',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Province Officer',
        ]);

        $province1 = User::create([
            'user_username' => 'province1',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Province Officer 2',
            'province' => '2',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Province Officer',
        ]);
        $province2 = User::create([
            'user_username' => 'province2',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Province Officer 3',
            'province' => '3',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Province Officer',
        ]);


        // กำหนด Role ให้ User
        // $admin->assignRole('admin');
        $province->assignRole('Province Officer');
        $province1->assignRole('Province Officer');
        $province2->assignRole('Province Officer');







        $central = User::create([
            'user_username' => 'central',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Central Officer 1',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Central Officer',
        ]);

        // กำหนด Role ให้ User
        // $admin->assignRole('admin');
        $central1 = User::create([
            'user_username' => 'central1',
            'user_name_title' => 'Mr.',
            'user_fullname' => 'Central Officer 2',
            'province' => '1',
            'user_password' => Hash::make('Pass1234'),
            'user_role' => 'Central Officer',
        ]);



        $central->assignRole('Central Officer');
        $central1->assignRole('Central Officer');
    }
}
