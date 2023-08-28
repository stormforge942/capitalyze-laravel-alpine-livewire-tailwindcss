<?php
 
namespace App\Console\Commands;
 
use App\Models\Hkex;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
 
class CreateHkex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hkex:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all HKEX from the production database';
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = DB::connection('pgsql-xbrl')
        ->table('hkex_statements')
        ->whereNotNull('symbol') // make sure 'symbol' is not null
        ->select('short_name', 'symbol')->distinct()->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
            if (isset($value->symbol) && !empty($value->symbol)) {
                Log::debug("Symbol is set and not empty: {$value->symbol}");
                try {
                    $hkex = Hkex::updateOrCreate(
                        [
                            'symbol' => $value->symbol, 
                            'short_name' => $value->short_name
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding company: {$e->getMessage()}");
                }
            }
        }
    }
}