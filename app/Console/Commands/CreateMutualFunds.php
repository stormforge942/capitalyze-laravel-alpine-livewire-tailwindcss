<?php
 
namespace App\Console\Commands;
 
use App\Models\MutualFunds;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
 
class CreateMutualFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mutualFunds:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Mutual Funds from the production database';
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = DB::connection('pgsql-xbrl')
        ->table('public.mutual_fund_holdings')
        ->whereNotNull('symbol') // make sure 'symbol' is not null
        ->select('registrant_name', 'symbol')->distinct()->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
            $mutualFund = MutualFunds::firstOrCreate(
                ['cik' => $value->cik], 
                ['registrant_name' => $value->registrant_name]
            );
        }
    }
}