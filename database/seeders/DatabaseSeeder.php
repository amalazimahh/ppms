<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            ContractorTableSeeder::class,
            ClientMinistryTableSeeder::class,
            ArchitectTableSeeder::class,
            MechanicalElectricalTableSeeder::class,
            CivilStructuralTableSeeder::class,
            QuantitySurveyorTableSeeder::class,
            StatusSeeder::class,
        ]);
    }
}
