<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientMinistryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('client_ministry')->insert([
            [
                'ministryName'=> 'Prime Minister\'s Office / Pejabat Perdana Menteri',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Culture, Youth, and Sports / Kementerian Belia dan Sukan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Defence / Kementerian Pertahanan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Development / Kementerian Pembangunan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Education / Kementerian Pendidikan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Finance and Economy / Kementerian Kewangan dan Ekonomi',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Foreign Affairs / Kementerian Luar Negeri',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Health / Kementerian Kesihatan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Home Affairs / Kementerian Dalam Negeri',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Primary Resources and Tourism / Kementerian Sumber Utama dan Pelancongan',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Religious Affairs / Kementerian Hal Ehwal Agama',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'ministryName'=> 'Ministry of Transport and Infocommunications / Kementerian Perhubungan dan Infokomunikasi',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
