<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use function now;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the admin user already exists, and delete it if so
        $existingAdmin = User::where('email', 'admin@school.com')->first();
        if ($existingAdmin) {
            $existingAdmin->delete();
        }

        // Create the admin user
        $user = User::create([
            'name' => 'Admin User', 
            'email' => 'admin@school.com', 
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign the 'admin' role to the user
        $adminRole = Role::findByName('admin');
        $user->assignRole($adminRole);

        // Assign all permissions to the admin
        $adminRole->givePermissionTo(Permission::all());
    }
}
