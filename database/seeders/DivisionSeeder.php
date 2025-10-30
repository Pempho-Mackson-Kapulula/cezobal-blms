<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    public function run()
    {
        DB::table('divisions')->insert([
            ['name' => "Men's Super League", 'age_bracket' => null],
            ['name' => "Women's Super League", 'age_bracket' => null],
            ['name' => "Men's League B", 'age_bracket' => null],
            ['name' => "Women's League B", 'age_bracket' => null],
            ['name' => "U18 Summer League", 'age_bracket' => 'U18'],
        ]);
    }
}
