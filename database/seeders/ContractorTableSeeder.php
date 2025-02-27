<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contractor')->insert([
            [
                'name'=> 'LCY Development Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'W.W. & Jessi Co Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Brusin Trading Company Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Sonnata Sdn. Bhd.',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Borneo United Enterprise Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'W.L.W. Dev. Trad',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Technotest Sdn Bhd',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
