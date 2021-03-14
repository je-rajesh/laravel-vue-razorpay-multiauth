<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'description' => 'it has full power',
            'display_name' => 'admin',
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'it is a normal user',
        ]);

        $user = User::factory()->create([
            'email' => 'user@gmail.com',
        ]);

        $admin = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $admin->attachRole($adminRole);
        $user->attachRole($userRole);
        
    }
}
