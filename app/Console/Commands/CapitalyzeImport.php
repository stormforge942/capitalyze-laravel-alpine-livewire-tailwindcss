<?php

namespace App\Console\Commands;

use App\Console\Commands\Artisan;
use Illuminate\Console\Command;

class CapitalyzeImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capitalyze:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all data to tables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('company:import');
        $this->call('fund:import');
        $this->call('euronext:import');
        $this->call('lse:import');
        $this->call('shanghai:import');
        $this->call('japan:import');
        $this->call('tsx:import');
        $this->call('mutualFunds:import');
        $this->call('etf:import');
        $this->call('hkex:import');
        $this->call('otc:import');
        $this->call('navbar:import');
        $this->call('frankfurt:import');
        $this->call('shenzhen:import');
        $this->call('groups:import');
        $this->call('navbarGroupShows:create');
    }
}
