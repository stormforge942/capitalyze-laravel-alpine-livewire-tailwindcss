<?php

namespace App\Console\Commands;

use App\Models\Etf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateEtf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etf:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Etf from the production database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $collection = DB::connection('pgsql-xbrl')
            ->table('public.etf_holdings')
            ->whereNotNull('cik')
            ->select('registrant_name', 'cik', 'etf_symbol')
            ->distinct()
            ->get();

        foreach ($collection as $value) {
            try {
                Etf::create([
                    'cik' => $value->cik,
                    'registrant_name' => $value->registrant_name,
                    'etf_symbol' => $value->etf_symbol,
                ]);
            } catch (\Exception $e) {
                Log::error("Error creating or etf: {$e->getMessage()}");
            }
        }

        $this->info('Etfs import completed');
    }
}
