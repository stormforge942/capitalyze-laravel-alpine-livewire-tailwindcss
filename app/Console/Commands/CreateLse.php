<?php
 
namespace App\Console\Commands;
 
use App\Models\Lse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
 
class CreateLse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lse:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all LSEs from the production database';
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = DB::connection('pgsql-xbrl')
        ->table('lse_statements')
        ->whereNotNull('symbol') // make sure 'symbol' is not null
        ->select('registrant_name', 'symbol', 'market', 'market_segment', 'share_register_country')->distinct()->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
            if (isset($value->symbol) && !empty($value->symbol)) {
                Log::debug("Symbol is set and not empty: {$value->symbol}");
                try {
                    $lse = Lse::updateOrCreate(
                        [
                            'symbol' => $value->symbol, 
                            'registrant_name' => $value->registrant_name, 
                            'market' => $value->market, 
                            'market_segment' => $value->market_segment,
                            'share_register_country' => $value->share_register_country
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding company: {$e->getMessage()}");
                }
            }
        }
    }
}