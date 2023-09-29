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
            ->whereNotNull('cik') // make sure 'cik' is not null
            ->whereNotNull('class_name')
            ->select('registrant_name', 'cik', 'fund_symbol', 'series_id', 'class_id', 'class_name')
            ->distinct()
            ->get();

        $collection = $query->collect();

        foreach ($collection as $value) {
            if (isset($value->cik) && !empty($value->cik)) {
                Log::debug("CIK is set and not empty: {$value->cik}");
                try {
                    $mutualFund = MutualFunds::updateOrCreate(
                        [
                            'cik' => $value->cik,
                            'registrant_name' => $value->registrant_name,
                            'fund_symbol' => $value->fund_symbol,
                            'series_id' => $value->series_id,
                            'class_id' => $value->class_id,
                            'class_name' => $value->class_name,
                        ]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding company: {$e->getMessage()}");
                }
            }
        }
        $this->info('Mutual Funds import completed');
    }
}
