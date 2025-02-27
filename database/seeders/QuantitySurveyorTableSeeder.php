<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class QuantitySurveyorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('quantity_surveyor')->insert([
            [
                'name'=> 'Hanafi Konsaltan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'MRBC Partnership',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Utamacon (B) Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Juruukur Bahan dan Pengurusan Utamacon',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Z-Arif Consultants',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'HZ & Associates',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Perunding Juruukurbahan KWC',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'QS Section, Department of Technical Services',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
