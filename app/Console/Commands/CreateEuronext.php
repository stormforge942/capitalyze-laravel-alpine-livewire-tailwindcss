<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
 
class CreateEuronext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'euronext:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all euronexts from the production database';
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = DB::connection('pgsql-xbrl')
        ->table('euronext_statements')
        ->select('symbol', 'registrant_name', 'market', 'market_full_name')
        ->whereNotNull('symbol') // make sure 'symbol' is not null
        ->distinct()->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
            try {
                $company = Company::updateOrCreate(
                    [
                        'ticker' => $value->symbol, 
                        'registrant_name' => $value->registrant_name, 
                        'market' => $value->market, 
                        'market_full_name' => $value->market_full_name
                    ]
                );
            } catch (\Exception $e) {
                Log::error("Error creating or finding company: {$e->getMessage()}");
            }
        }
    }
}