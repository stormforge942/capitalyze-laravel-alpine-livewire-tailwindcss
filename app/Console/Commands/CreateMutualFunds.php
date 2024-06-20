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
        $batchSize = 10000;
        $offset = 0;
        $totalImported = 0;
        
        do {
            $batch = DB::connection('pgsql-xbrl')
                ->table('public.mutual_fund_holdings')
                ->whereNotNull('cik')
                ->whereNotNull('class_name')
                ->select('registrant_name', 'cik', 'fund_symbol', 'series_id', 'class_id', 'class_name')
                ->distinct()
                ->offset($offset)
                ->limit($batchSize)
                ->get();
        
            $offset += $batchSize;
            
            Log::info("Offset updated to: {$offset}");

            foreach ($batch as $value) {
                if (!empty($value->cik)) {
                    try {
                        MutualFunds::create([
                            'cik' => $value->cik,
                            'registrant_name' => $value->registrant_name,
                            'fund_symbol' => $value->fund_symbol,
                            'series_id' => $value->series_id,
                            'class_id' => $value->class_id,
                            'class_name' => $value->class_name
                        ]);
                        $totalImported++;
                    } catch (\Exception $e) {
                        Log::error("Error creating or finding company: {$e->getMessage()}");
                    }
                }
            }
        } while ($batch->isNotEmpty());
        
        $this->info("Mutual Funds import completed. Total records imported: {$totalImported}");
    }
}
