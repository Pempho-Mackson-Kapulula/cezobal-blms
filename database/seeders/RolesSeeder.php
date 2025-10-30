<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\Models\Team;
use App\Models\Game;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define roles
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $teamManager = Bouncer::role()->firstOrCreate([
            'name' => 'team_manager',
            'title' => 'Team Manager',
        ]);

        $statistician = Bouncer::role()->firstOrCreate([
            'name' => 'statistician',
            'title' => 'Statistician',
        ]);

        $scorekeeper = Bouncer::role()->firstOrCreate([
            'name' => 'scorekeeper',
            'title' => 'Scorekeeper',
        ]);

        // Define and assign abilities to the 'admin' role
        Bouncer::allow($admin)->to('access-admin-dashboard');
        Bouncer::allow($admin)->toManage(User::class);
        //Bouncer::allow($admin)->toManage(Team::class);
        //Bouncer::allow($admin)->toManage(Game::class);
        // You can use ->everything() for broad permissions
        // Bouncer::allow($admin)->everything();

        // Define and assign abilities to the 'team_manager' role
        Bouncer::allow($teamManager)->to('access-team-manager-dashboard');
        //Bouncer::allow($teamManager)->toOwn(Team::class)->to('view');
        //Bouncer::allow($teamManager)->toOwn(Team::class)->to('update');
        //Bouncer::allow($teamManager)->toOwn(Team::class)->to('manage-players');

        // Define and assign abilities to the 'statistician' role
        Bouncer::allow($statistician)->to('access-statistician-dashboard');
        Bouncer::allow($statistician)->to('view-all-game-stats');
        Bouncer::allow($statistician)->to('edit-game-stats');

        // Define and assign abilities to the 'scorekeeper' role
        Bouncer::allow($scorekeeper)->to('access-scorekeeper-dashboard');
        Bouncer::allow($scorekeeper)->to('record-game-scores');
        Bouncer::allow($scorekeeper)->to('edit-game-scores');

        // Seed an admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => Hash::make('12345678'), 'status' => 'active']
        );
        $adminUser->assign('admin');

        // Seed a team manager user
        $teamManagerUser = User::firstOrCreate(
            ['email' => 'team_manager@example.com'],
            ['name' => 'Manager', 'password' => Hash::make('12345678'), 'status' => 'active']
        );
        $teamManagerUser->assign('team_manager');

        $scoreKeepers = [
            ['name' => 'Scorekeeper 1', 'email' => 'score1@example.com'],
            ['name' => 'Scorekeeper 2', 'email' => 'score2@example.com'],
        ];

        foreach ($scoreKeepers as $sk) {
            $user = User::firstOrCreate(
                ['email' => $sk['email']],
                ['name' => $sk['name'], 'password' => Hash::make('12345678'), 'status' => 'active']
            );
            $user->assign('scorekeeper');
        }

        // Seed statisticians
        $statisticians = [
            ['name' => 'Statistician 1', 'email' => 'stat1@example.com'],
            ['name' => 'Statistician 2', 'email' => 'stat2@example.com'],
        ];

        foreach ($statisticians as $stat) {
            $user = User::firstOrCreate(
                ['email' => $stat['email']],
                ['name' => $stat['name'], 'password' => Hash::make('12345678'), 'status' => 'active']
            );
            $user->assign('statistician');
        }
    }
}

