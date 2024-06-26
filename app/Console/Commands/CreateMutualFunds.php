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
        DB::connection('pgsql-xbrl')
            ->table('public.mutual_fund_holdings')
            ->select('registrant_name', 'cik', 'fund_symbol', 'series_id', 'class_id', 'class_name')
            ->chunk(10000, function ($collection) {
                foreach ($collection as $value) {
                    if (!data_get($value, 'cik') || !data_get($value, 'class_name')) {
                        continue;
                    }

                    try {
                        MutualFunds::query()->updateOrCreate([
                            'cik' => $value->cik,
                            'registrant_name' => $value->registrant_name,
                            'fund_symbol' => $value->fund_symbol,
                            'series_id' => $value->series_id,
                            'class_id' => $value->class_id,
                            'class_name' => $value->class_name
                        ]);
                    } catch (\Exception $e) {
                        Log::error("Error creating or finding company: {$e->getMessage()}");
                    }
                }
            });


        $this->info('Mutual Funds import completed');
    }
}
