<?php
 
namespace App\Console\Commands;
 
use App\Models\Shanghai;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
 
class CreateShanghai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shanghai:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Shanghais from the production database';
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = DB::connection('pgsql-xbrl')
        ->table('shanghai_statements')
        ->whereNotNull('symbol') // make sure 'symbol' is not null
        ->select('symbol', 'full_name', 'short_name')->distinct()->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
            if (isset($value->symbol) && !empty($value->symbol)) {
                Log::debug("Symbol is set and not empty: {$value->symbol}");
                try {
                    $shanghai = Shanghai::updateOrCreate(
                        [
                            'symbol' => $value->symbol, 
                            'full_name' => $value->full_name, 
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