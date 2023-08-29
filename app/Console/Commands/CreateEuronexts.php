<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Euronext;
use Illuminate\Support\Facades\Log;
 
class CreateEuronexts extends Command
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
        ->whereNotNull('symbol') // make sure 'symbol' is not null
        ->select('symbol', 'registrant_name', 'market', 'market_full_name', 'isin')
        ->distinct()->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
                try {
                    $euronext = Euronext::updateOrCreate(
                        ['symbol' => $value->symbol]
                    );
                    
                    if (!empty($value->registrant_name)){
                        $euronext->registrant_name = $value->registrant_name;
                    }

                    if (!empty($value->market)){
                        $euronext->market = $value->market;
                    }

                    if (!empty($value->market_full_name)){
                        $euronext->market_full_name = $value->market_full_name;
                    }

                    if (!empty($value->isin)){
                        $euronext->isin = $value->isin;
                    }

                    $euronext->save();
                } catch (\Exception $e) {
                    Log::error("Error creating or finding euronext: {$e->getMessage()}");
                }
        }
    }
}