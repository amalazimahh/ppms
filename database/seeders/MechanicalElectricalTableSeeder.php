<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MechanicalElectricalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mechanical_electrical')->insert([
            [
                'name'=> 'Sepakat Setia Perunding',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'LKA Consulting Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Perkhidmatan Perundingan Dan Pengurusan Ilmu Alim',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Hamidon & Associates',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Othman & Associates Consulting Engineers',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Jurutera Perunding LCE',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Regional Consultants',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Hamzah Hassan Consultant',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Jurutera OMC',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Jurutera Perunding RCS (B) Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
