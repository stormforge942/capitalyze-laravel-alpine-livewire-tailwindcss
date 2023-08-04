<?php
 
namespace App\Console\Commands;
 
use App\Models\Japan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
 
class CreateJapan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'japan:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Japan from the production database';
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = DB::connection('pgsql-xbrl')
        ->table('japan_statements')
        ->whereNotNull('symbol') // make sure 'symbol' is not null
        ->select('registrant_name', 'symbol', 'isin', 'industry')->distinct()->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
            if (isset($value->symbol) && !empty($value->symbol)) {
                Log::debug("Symbol is set and not empty: {$value->symbol}");
                try {
                    $japan = Japan::updateOrCreate(
                        [
                            'symbol' => $value->symbol, 
                            'registrant_name' => $value->registrant_name, 
                            'isin' => $value->isin, 
                            'industry' => $value->industry
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding company: {$e->getMessage()}");
                }
            }
        }
    }
}