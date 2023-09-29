<?php

namespace App\Console\Commands;

use App\Models\Otc;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateOtc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otc:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all OTC from the production database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $query = DB::connection('pgsql-xbrl')
            ->table('otc_statements')
            ->whereNotNull('symbol') // make sure 'symbol' is not null
            ->select('company_name', 'symbol')
            ->distinct()
            ->get();

        $collection = $query->collect();

        foreach ($collection as $value) {
            if (isset($value->symbol) && !empty($value->symbol)) {
                Log::debug("Symbol is set and not empty: {$value->symbol}");
                try {
                    Otc::updateOrCreate(
                        [
                            'symbol' => $value->symbol,
                            'company_name' => $value->company_name,
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding otc: {$e->getMessage()}");
                }
            }
        }
        $this->info('OTC import completed');
    }
}
