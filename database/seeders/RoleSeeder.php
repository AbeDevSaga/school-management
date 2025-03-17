<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'student']);

        Permission::create(['name' => 'manage teachers']);
        Permission::create(['name' => 'manage students']);
        Permission::create(['name' => 'manage subjects']);
        Permission::create(['name' => 'manage grades']);
        Permission::create(['name' => 'assign marks']);
        Permission::create(['name' => 'view grades']);

        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        $teacher = Role::findByName('teacher');
        $teacher->givePermissionTo(['assign marks', 'view grades']);

        $student = Role::findByName('student');
        $student->givePermissionTo(['view grades']);
    }
}
