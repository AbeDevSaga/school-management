<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        {
            // Create roles
            $adminRole = Role::firstOrCreate(['name' => 'admin']);
            $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
            $studentRole = Role::firstOrCreate(['name' => 'student']);

            // Assign all permissions to Admin
            $adminRole->givePermissionTo(Permission::all());

            // Assign limited permissions to Teacher
            $teacherRole->givePermissionTo([
                'view_student',
                'create_student',
                'edit_student',
                'delete_student',
                'view_grade',
                'create_grade',
                'edit_grade',
                'delete_grade',
            ]);

            // Assign view-only permissions to Student
            $studentRole->givePermissionTo([
                'view_grade',
            ]);
        }
    }
}
