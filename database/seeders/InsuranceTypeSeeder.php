<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsuranceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('insurance_type')->insert([
            [
                'name'=> 'Fire Insurance',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Workman Compensation Insurance',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Public Liability Insurance',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'=> 'Others',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
