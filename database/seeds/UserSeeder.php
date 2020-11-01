<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        
        User::create([
            'role_id' => 1,
            'name' => 'Admin',
            'email' => 'marclesterlagunday@gmail.com',
            'password' => HASH::make('password')
        ]);
    }
}
