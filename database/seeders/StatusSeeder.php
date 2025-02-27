<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'name' => 'Pre-Design',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Design Submission',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tender',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Post-Completion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
