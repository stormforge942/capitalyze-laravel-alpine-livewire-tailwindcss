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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!app()->environment('local')){
            $this->error("This command can only be run in local environment");
            return;
        }

        Navbar::get()->each->delete();

        $this->call('navbar:import');
        $this->call('groups:import');
        $this->call('navbarGroupShows:create');

        return Command::SUCCESS;
    }
}
