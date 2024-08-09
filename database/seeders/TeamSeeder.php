<?php

namespace Database\Seeders;

use App\Enums\Plan;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        if (! $user->team) {
            $team = Team::create([
                'name' => 'Capitalyze',
                'plan' => Plan::COMPANY,
                'owner_id' => $user->id,
            ]);

            $user->update(['current_team_id' => $team->id]);
        }
    }
}
