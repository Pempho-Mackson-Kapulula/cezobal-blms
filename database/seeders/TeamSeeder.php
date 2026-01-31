<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Division;
use App\Models\Court;
use Faker\Factory as Faker;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $divisions = Division::all()->keyBy('name');
        $courts = Court::all();

        if ($courts->isEmpty()) {
            $this->command->error("No courts found. Please seed courts first.");
            return;
        }

        $courtIndex = 0;
        $pickCourt = function () use ($courts, &$courtIndex) {
            $court = $courts[$courtIndex % $courts->count()];
            $courtIndex++;
            return $court->id;
        };

        $teamsByDivision = [
            "Men's Super League" => [
                'Kamuzu Barracks',
                'Bravehearts Men',
                'Disciples',
                'Bravehearts Boys',
                'Central Knights',
                'ABC Lions',
                'Cougars',
                'Bunda Buffaloes',
                'Central Spartans',
                'Paratroopers'
            ],
            "Women's Super League" => [
                'UNILI Ark Angels',
                'Bravehearts Ladies',
                'Bravehearts Girls',
                'Dynamites',
                'LAB Co-Flyers',
                'Shockers'
            ],
            "Men's League B" => [
                'Dream Team',
                'Katana "The Boyz"',
                'The Onyx',
                'Destroyers',
                'LAB Flyers',
                'Armour',
                'BN Mimbulu',
                'SOS Magic',
                'NextGen Gold Boys',
                'Shockers Boys',
                'Likuni Clippers',
                'BS Expendables',
                'NRC Pythons',
                'Kasungu Sparks',
                'Don Bosco Rising Stars',
                'Trojans',
                'Bunda Calves',
                'Baseline Aces',
            ],
            "Women's League B" => [
                'Bravehearts Yots',
                'Katana',
                'Bunda Olivettes',
                'Green Basketball Club',
                'ABC Lady Lions',
                'NRC Lady Pythons',
                'NextGen Gold Girls'
            ],
            "U18 Summer League" => [
                'Junior Fire U18',
                'Young Stars U18',
                'Rockets U18',
                'Comets U18',
                'Novas U18',
                'Meteors U18'
            ],
        ];

        foreach ($teamsByDivision as $divisionName => $teams) {
            $division = $divisions[$divisionName] ?? null;
            if (!$division)
                continue;

            foreach ($teams as $teamName) {
                $teamId = DB::table('teams')->insertGetId([
                    'name' => $teamName,
                    'division_id' => $division->id,
                    'home_court_id' => $pickCourt(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Seed players with realistic 2026 profiles
                // Seed players with realistic 2026 profiles
                for ($i = 1; $i <= rand(8, 12); $i++) {
                    // 1. Determine gender and league type
                    $gender = str_contains($divisionName, "Women's") ? 'female' : 'male';
                    $isMens = ($gender === 'male');

                    // 2. Build clean name
                    $firstName = $faker->firstName($gender);
                    $lastName = $faker->lastName;
                    $fullName = "{$firstName} {$lastName}";

                    // 3. Generate physical attributes
                    $heightInches = $isMens ? $faker->numberBetween(72, 82) : $faker->numberBetween(66, 75);
                    $height = floor($heightInches / 12) . "'" . ($heightInches % 12) . '"';
                    $weight = ($isMens ? $faker->numberBetween(50, 100) : $faker->numberBetween(56, 100)) . " kg";

                    // 4. Generate Basketball Background/History
                    $history = $faker->randomElement([
                        "a former standout from the Lilongwe youth circuits",
                        "a seasoned veteran who previously played in the regional championships",
                        "a rising prospect who transitioned from the U18 summer league",
                        "an athletic marvel known for dominant play in the inter-college games",
                        "a tactical specialist with a deep understanding of the CEZOBAL system"
                    ]);

                    $playingStyle = $faker->randomElement([
                        "provides elite rim protection and interior scoring.",
                        "excels at floor spacing with a lethal perimeter shot.",
                        "is a lockdown defender capable of guarding multiple positions.",
                        "orchestrates the offense with high-level playmaking and vision.",
                        "is a high-energy transition threat who thrives in the open court."
                    ]);

                    // 5. Combine everything into the single 'bio' column
                    $customBio = "Standing {$height} and weighing {$weight}, {$firstName} is {$history}. " .
                        "Currently playing for {$teamName}, this athlete {$playingStyle} " .
                        "Expected to be a cornerstone for the team throughout the 2026 campaign.";

                    DB::table('players')->insert([
                        'name' => $fullName,
                        'team_id' => $teamId,
                        'position' => $faker->randomElement(['PG', 'SG', 'SF', 'PF', 'C']),
                        'jersey_number' => $faker->unique(true)->numberBetween(0, 99),
                        'bio' => $customBio,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }


            }
        }

        $this->command->info("2026 Teams and Players seeded with realistic profiles successfully.");
    }
}
