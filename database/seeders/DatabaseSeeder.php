<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Venue;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            DivisionSeeder::class,
            CourtSeeder::class,
            TimeSlotSeeder::class,
            TeamSeeder::class,
            RolesSeeder::class,
        ]);
    }
}
