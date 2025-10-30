<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\Court;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $divisions = Division::all()->keyBy('name'); // key by name
        $courts = Court::all();

        if ($courts->isEmpty()) {
            $this->command->error("No courts found. Please seed courts first.");
            return;
        }

        // Cycle through courts
        $courtIndex = 0;
        $pickCourt = function() use ($courts, &$courtIndex) {
            $court = $courts[$courtIndex % $courts->count()];
            $courtIndex++;
            return $court->id;
        };

        $teamsByDivision = [
            "Men's Super League" => [
                'Kamuzu Barracks', 'Bravehearts Men', 'Disciples', 'Bravehearts Boys',
                'Central Knights', 'ABC Lions', 'Cougars', 'Bunda Buffaloes',
                'Central Spartans', 'Paratroopers'
            ],
            "Women's Super League" => [
                'UNILI Ark Angels', 'Bravehearts Ladies', 'Bravehearts Girls',
                'Dynamites', 'LAB Co-Flyers', 'Shockers'
            ],
            "Men's League B" => [
                'Dream Team', 'Katana "The Boyz"', 'The Onyx', 'Destroyers',
                'LAB Flyers', 'Armour', 'BN Mimbulu', 'SOS Magic', 'NextGen Gold Boys',
                'Shockers Boys', 'Likuni Clippers', 'BS Expendables', 'NRC Pythons',
                'Kasungu Sparks', 'Don Bosco Rising Stars', 'Trojans', 'Bunda Calves', 'Baseline Aces',
            ],
            "Women's League B" => [
                'Bravehearts Yots', 'Katana', 'Bunda Olivettes', 'Green Basketball Club',
                'ABC Lady Lions', 'NRC Lady Pythons', 'NextGen Gold Girls'
            ],
            "U18 Summer League" => [
                'Junior Fire U18', 'Young Stars U18', 'Rockets U18', 'Comets U18', 'Novas U18', 'Meteors U18'
            ],
        ];

        foreach ($teamsByDivision as $divisionName => $teams) {
            $division = $divisions[$divisionName] ?? null;
            if (!$division) {
                $this->command->warn("Division '{$divisionName}' not found. Skipping.");
                continue;
            }

            foreach ($teams as $teamName) {
                DB::table('teams')->insert([
                    'name' => $teamName,
                    'division_id' => $division->id,
                    'home_court_id' => $pickCourt(),
                ]);
            }
        }

        $this->command->info("Teams seeded successfully.");
    }
}
