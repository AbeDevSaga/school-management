<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use function now;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User', 
            'email' => 'admin@school.com', 
            'password' => Hash::make('admin123'), 
            'role' => 'admin',  
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
