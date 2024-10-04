<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Navbar;
use App\Models\Groups;
use App\Models\NavbarGroupShows;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CreateNavbarGroupShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'navbarGroupShows:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all showed navbars';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $navbars = Navbar::all();
        $groups = Groups::all();

        foreach ($navbars as $navbar) {
            $isBottomNavbar = Str::startsWith($navbar->route_name, Navbar::PRIMARY_NAV);
            $isUpperNavbar = in_array($navbar->route_name, [
                '',
                'track-investors',
                'insider-transactions',
                'event-filings',
                'earnings-calendar',
                'screener',
                'economics-calendar',
                'delistings',
                'etf-filings',
                'euronexts',
                'lses',
                'tsxs',
                'shanghais',
                'japans',
                'hkexs',
                'otcs',
                'frankfurts',
                'shenzhens',
                'press.release',
            ]);

            if ($isBottomNavbar || $isUpperNavbar) {
                foreach ($groups as $group) {
                    if (NavbarGroupShows::query()->where([
                        'navbar_id' => $navbar->id,
                        'group_id' => $group->id
                    ])->exists()) {
                        continue;
                    }

                    NavbarGroupShows::query()->create([
                        'navbar_id' => $navbar->id,
                        'group_id' => $group->id,
                        'show' => true
                    ]);
                }
            }
        }
        $this->info('NavbarGroupShows created successfully!');
    }
}
