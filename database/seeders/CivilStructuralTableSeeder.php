<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CivilStructuralTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('civil_structural')->insert([
            [
                'name'=> 'Jurusy Perunding',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Othmand & Associates Consulting Engineers',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Sepakat Setia Perunding (B) Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'KRK Consultants',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Perunding Primareka',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Adwan and Associates',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Jurutera Tempatan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Zin Salleh & Partnership',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Jumin Marsal Perunding',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'KR Kamarulzaman & Associates',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Baharuddin and Associates Consulting Engineers',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'L&W Sepakat',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
