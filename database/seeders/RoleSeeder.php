<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง Role
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'Volunteer']);
        Role::create(['name' => 'Province Officer']);
        Role::create(['name' => 'Central Officer']);

        // // สร้าง Permission
        // Permission::create(['name' => 'edit articles']);
        // Permission::create(['name' => 'delete articles']);

        // // กำหนดสิทธิ์ให้ Role
        // $admin->givePermissionTo(['edit articles', 'delete articles']);
        // $volunteer->givePermissionTo(['edit articles']);
    }
}
