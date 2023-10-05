<?php

namespace App\Console\Commands;

use App\Models\Frankfurt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateFrankfurt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'frankfurt:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all Frankfurt from the production database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $collection = DB::connection('pgsql-xbrl')
            ->table('frankfurt_statements')
            ->whereNotNull('symbol') // make sure 'symbol' is not null
            ->select('company_name', 'symbol')
            ->distinct()
            ->get();

        foreach ($collection as $value) {
            try {
                Frankfurt::updateOrCreate([
                    'symbol' => $value->symbol,
                    'company_name' => $value->company_name,
                ]);
            } catch (\Exception $e) {
                Log::error("Error creating or finding frankfurt: {$e->getMessage()}");
            }
        }

        $this->info('Frankfurt import completed');
    }
}
