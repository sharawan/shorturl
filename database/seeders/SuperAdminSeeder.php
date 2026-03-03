<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default company and super admin user
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'company_id' => 1
        ]);

         \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => 1
        ]);
         \App\Models\User::create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'company_id' => 1
        ]);
        \App\Models\Company::create([
            'name' => 'Default Company',
            'email' => 'default@gmail.com'
        ]);
        \App\Models\Company::create([
            'name' => 'Other Company',
            'email' => 'other@gmail.com'
        ]);


    }
}
