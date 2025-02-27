<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ArchitectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('architect')->insert([
            [
                'name'=> 'Arkitek Alamreka',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'PDO Chartered Arkitek',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Rudi Rahim Arkitek',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Arkitek Haza',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Arkitek Idris',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'OWMP International',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Arkitek Urusreka ',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Abdullah Ahmad Architect',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Seri Sezaman Architects',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Arkitek Aziz',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
