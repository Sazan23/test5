<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('records')->insert([
            [
                'file_id' => 1,
                'record_name' => 'Harlan Nolan',
                'record_phone' => '1234567898552',
                'record_email' => 'semper@outlook.edu',
                'record_date' => '27.06.2022',
                'record_company' => 'Fames Ac Associates',
                'record_city' => 'Okene',
                'record_region' => 'Ulster',
                'record_guid' => '98B0F164-29AC-8DA7-8D63-758ED2195F85',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'file_id' => 1,
                'record_name' => 'Carl Phillips',
                'record_phone' => '6541+518+665',
                'record_email' => 'proin.non@yahoo.couk',
                'record_date' => '31.07.2023',
                'record_company' => 'Elementum At Egestas Limited',
                'record_city' => 'Cork',
                'record_region' => 'Picardie',
                'record_guid' => 'D23D13C9-121B-65DC-8E7B-DEED98C703A2',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'file_id' => 1,
                'record_name' => 'Anthony Kline',
                'record_phone' => '6548665565',
                'record_email' => 'netus@icloud.couk',
                'record_date' => '17.08.2022',
                'record_company' => 'Tempus Ltd	Agartala',
                'record_city' => 'Cork',
                'record_region' => 'Munster',
                'record_guid' => '42A86A07-8733-C474-1439-EA4724793E34',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'file_id' => 2,
                'record_name' => 'Alana Powers',
                'record_phone' => '6266998154565',
                'record_email' => 'risus@aol.ca',
                'record_date' => '12.08.2023',
                'record_company' => 'Dui PC',
                'record_city' => 'Iquitos',
                'record_region' => 'Kansas',
                'record_guid' => '1AEED6DA-57AD-7DA1-8B11-464456175755',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'file_id' => 2,
                'record_name' => 'Brooke Church',
                'record_phone' => '25632145856',
                'record_email' => 'aliquam@google.net',
                'record_date' => '03.02.2023',
                'record_company' => 'Nec Company',
                'record_city' => 'Rivne',
                'record_region' => 'Queensland',
                'record_guid' => 'DE5C96A8-362D-4313-3351-9C5728C027DB',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ],
            [
                'file_id' => 2,
                'record_name' => 'Natalie Rivera',
                'record_phone' => '584563321576554',
                'record_email' => 'phasellus.dolor@google.com',
                'record_date' => '08.06.2022',
                'record_company' => 'Sagittis Semper Nam Institute',
                'record_city' => 'Montague',
                'record_region' => 'Alberta',
                'record_guid' => '8D7D443F-E0D1-B059-7703-B50D70CE9B91',
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
