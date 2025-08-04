<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Faculty;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Peran
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $facultyAdminRole = Role::create(['name' => 'Faculty Admin']);

        // Buat user Super Admin pertama
        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@kiosk.com',
            'password' => bcrypt('password'), // Ganti dengan password yang aman!
            'faculty_id' => null, // Super admin tidak terikat pada fakultas
        ]);
        $superAdminUser->assignRole($superAdminRole);

        // Buat contoh fakultas dan adminnya
        $faculty = Faculty::create([
            'name' => 'Unit Penunjang Akademik TIK',
            'slug' => 'unit-penunjang-akademik-tik'
        ]);

        $facultyAdminUser = User::create([
            'name' => 'Admin UPA TIK',
            'email' => 'admintik@kiosk.com',
            'password' => bcrypt('password'), // Ganti dengan password yang aman!
            'faculty_id' => $faculty->id,
        ]);
        $facultyAdminUser->assignRole($facultyAdminRole);
    }
}