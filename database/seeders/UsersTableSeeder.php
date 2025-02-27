<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@ppms.pwd.gov.bn',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'roles_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mohd',
                'email' => 'mohd@ppms.pwd.gov.bn',
                'email_verified_at' => now(),
                'password' => Hash::make('mohd1234'),
                'roles_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Puan Salfa',
                'email' => 'salfa@ppms.pwd.gov.bn',
                'email_verified_at' => now(),
                'password' => Hash::make('salfa1234'),
                'roles_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
