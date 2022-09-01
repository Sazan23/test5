<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('files')->insert([
            'file_name' => Str::random(10),
            'file_hash' => Hash::make(Str::random(5)),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }
}
