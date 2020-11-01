<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        
        Role::create([
            'role_name' => 'Administrator',
            'role_description' => 'super user'
        ]);

        Role::create([
            'role_name' => 'User',
            'role_description' => 'can add expenses'
        ]);
    }
}
