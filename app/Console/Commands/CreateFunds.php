<?php

namespace App\Console\Commands;

use App\Models\Fund;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fund:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all funds from the production database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $query = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->whereNotNull('cik') // make sure 'cik' is not null
        ->select('cik', 'investor_name')->distinct()->get();

        $collection = $query->collect();

        foreach($collection as $value) {
            $fund = Fund::firstOrCreate(
                ['cik' => $value->cik],
                ['name' => $value->investor_name]
            );
        }
        $this->info('All funds imported!');
    }
}
