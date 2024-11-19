<?php

namespace App\Console\Commands;

use App\Models\Navbar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class createNavbar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'navbars:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all navbar and groupShows items';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $navbars = Navbar::query()->get();
        
        Log::info('Navbars:', $navbars->toArray());
        
        $this->info('Fetch navbars successfully!');
    }
}
