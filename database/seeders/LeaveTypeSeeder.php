<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('leavetypes')->insert([
            'nameLeavetype' => 'Sick Leave',
            'description' => 'Used when a technician is not well',
            'maxDuration' => '7'
        ]);
    }
}
