<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        DB::table('user_type')->insert([
            'user_role' => "Super Admin",
            'status' => 1,
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);

        DB::table('users')->insert([
            'first_name' => "Admin",
            'last_name' => "Admin",
            'full_name' => "Admin Admin",
            'email' => "admin@master.com",
            'password' => Hash::make('Master@2021'),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'userimage' => 'default.png',
            'user_type' => 1,
            'status' => 1,
            'is_deleted' => 'N',
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
    }
}
