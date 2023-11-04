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
            $isBottomNavbar = Str::startsWith($navbar->route_name, ['company.', 'company-', 'lse.', 'tsx.', 'fund.', 'mutual-fund.', 'etf.', 'fund-', 'mutual-fund-', 'shanghai.', 'japan.', 'hkex.', 'euronext.', 'otc.', 'frankfurt.', 'shenzhen.']);
            $isUpperNavbar = $navbar->route_name === '' 
            || $navbar->route_name === 'earnings-calendar'
            || $navbar->route_name === 'economics-calendar'
            || $navbar->route_name === 'delistings'
            || $navbar->route_name === 'euronexts'
            || $navbar->route_name === 'lses'
            || $navbar->route_name === 'tsxs'
            || $navbar->route_name === 'shanghais'
            || $navbar->route_name === 'japans'
            || $navbar->route_name === 'hkexs'
            || $navbar->route_name === 'otcs'
            || $navbar->route_name === 'frankfurts'
            || $navbar->route_name === 'shenzhens'
            || $navbar->route_name === 'press.release';

            if ($isBottomNavbar || $isUpperNavbar) {
                foreach ($groups as $group) {
                    // Check if NavbarGroupShows entry already exists
                    $existingEntry = NavbarGroupShows::where('navbar_id', $navbar->id)
                        ->where('group_id', $group->id)
                        ->first();

                    if (!$existingEntry) {
                        // Create a new NavbarGroupShows entry
                        NavbarGroupShows::create([
                            'navbar_id' => $navbar->id,
                            'group_id' => $group->id,
                            'show' => true
                        ]);
                    }
                }
            }
        }
        $this->info('NavbarGroupShows created successfully!');
    }
}
