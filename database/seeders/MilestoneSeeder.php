<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('milestones')->insert([
            // pre-design stage
            [
                'statuses_id' => 1,
                'name' => 'MP1 - Project Terms of Reference',
            ],
            [
                'statuses_id' => 1,
                'name' => 'MP2 - Confirmation of Project Team',
            ],
            [
                'statuses_id' => 1,
                'name' => 'MP3 - Confirmation of Design Brief',
            ],
            [
                'statuses_id' => 1,
                'name' => 'MP4 - Completion of Preliminary Design',
            ],
            [
                'statuses_id' => 1,
                'name' => 'MP5 - Confirmation of Implementation Strategy',
            ],
            // design stage
            [
                'statuses_id' => 2,
                'name' => 'MD1 - Completion of Detailed Design',
            ],
            [
                'statuses_id' => 2,
                'name' => 'MD2 - Confirmation of Tender Specifications & Documentation',
            ],
            [
                'statuses_id' => 2,
                'name' => 'MD3 - Confirmation of Programme for Sourcing of Prime Cost Sum Items',
            ],
            // tender stage
            [
                'statuses_id' => 3,
                'name' => 'MT1 - Opening/Closing of Tender',
            ],
            [
                'statuses_id' => 3,
                'name' => 'MT2 - Evaluation/Recommendation of Tender',
            ],
            [
                'statuses_id' => 3,
                'name' => 'MT3 - Approval of Award',
            ],
            [
                'statuses_id' => 3,
                'name' => 'MT4 - Confirmation of Tender Programme for Nominated Sub-Contracts/Other Minor Contracts',
            ],
            // ongoing / construction stage
            [
                'statuses_id' => 4,
                'name' => 'MO1 - Confirmation of Implementation Strategy',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO1 - Completion of Initial Mobilisation',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO2 - Completion of Earthworks and Substructure Works',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO3 - Confirmation of Awards of Nominated Sub-Contracts/Other Contracts',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO4 - Completion of Structural Works',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO5 - Completion of Mechanical & Electrical Works, Finishes, and Fittings',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO6 - Completion of External Works',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO7 - Completion of Loose Furniture, Interior Design Works, etc.',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO8 - Completion of Services/Utilities',
            ],
            [
                'statuses_id' => 4,
                'name' => 'MO9 - Issuance of Certificate of Practical Completion',
            ],
            // post-completion stage
            [
                'statuses_id' => 5,
                'name' => 'MC1 - Handing Over to the Client',
            ],
            [
                'statuses_id' => 5,
                'name' => 'MC2 - Approval of Final Account',
            ],
            [
                'statuses_id' => 5,
                'name' => 'MC3 - Final Hand-Over of Project',
            ],
            [
                'statuses_id' => 5,
                'name' => 'MC4 - Finalisation of Final Professional Fees (for Consultant Services)',
            ],
        ]);
    }
}
