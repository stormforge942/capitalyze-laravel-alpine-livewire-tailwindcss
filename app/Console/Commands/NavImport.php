<?php

namespace App\Console\Commands;

use App\Models\Navbar;
use Illuminate\Console\Command;

class NavImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nav:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete and import all navbar items';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('navbar:import');
        $this->call('groups:import');
        $this->call('navbarGroupShows:create');

        return Command::SUCCESS;
    }
}
