<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);

        // Create Permissions
        $viewDashboardPermission = Permission::create(['name' => 'view_dashboard']);
        $createUserPermission = Permission::create(['name' => 'create_user']);
        $editUserPermission = Permission::create(['name' => 'edit_user']);
        $deleteUserPermission = Permission::create(['name' => 'delete_user']);

        // Assign Permissions to Roles
        $adminRole->permissions()->attach([
            $viewDashboardPermission->id, 
            $createUserPermission->id, 
            $editUserPermission->id, 
            $deleteUserPermission->id
        ]);
        
        $teacherRole->permissions()->attach([
            $viewDashboardPermission->id, 
            $editUserPermission->id
        ]);
        
        $studentRole->permissions()->attach([
            $viewDashboardPermission->id
        ]);
    }
}
