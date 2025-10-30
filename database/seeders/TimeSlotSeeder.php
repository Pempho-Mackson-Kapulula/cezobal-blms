<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    public function run()
    {
        DB::table('time_slots')->insert([
            ['start_time' => '08:00:00','end_time'=>'10:00:00'],
            ['start_time' => '10:30:00','end_time'=>'12:30:00'],
            ['start_time' => '13:00:00','end_time'=>'15:00:00'],
            ['start_time' => '15:30:00','end_time'=>'17:30:00'],
            ['start_time' => '18:00:00','end_time'=>'20:00:00'],
        ]);
    }
}
