<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtSeeder extends Seeder
{
    public function run()
    {
        $courts = [
            ['name' => 'KIS Court 1'],
            ['name' => 'KIS Premiere Bet' ],
            ['name' => 'ABC Macon Gym'], 
            ['name' => 'ABC Blue Gym'], 
            ['name' => 'Bingu National Stadium Court'],
            ['name' => 'LUANAR Court'], 
            ['name' => 'Bambino'], 
            ['name' => 'Salima Para'], 
            ['name' => 'Chinese Garden'], 
        ];

        DB::table('courts')->insert($courts);
    }
}
