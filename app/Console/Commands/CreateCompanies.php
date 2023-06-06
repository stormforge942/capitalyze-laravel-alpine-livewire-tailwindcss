<?php
 
namespace App\Console\Commands;
 
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
 
class CreateCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:import';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all companies from the sec website';
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = 'https://www.sec.gov/files/company_tickers.json';
        $json = file_get_contents($url);
        $json = json_decode($json);
    
        foreach($json as $key => $value) {
            if (isset($value->ticker) && !empty($value->ticker)) {
                Log::debug("Ticker is set and not empty: {$value->ticker}");
                try {
                    $company = Company::updateOrCreate(
                        ['cik' => $value->cik_str],
                        ['ticker' => $value->ticker, 'name' => $value->title]
                    );
                } catch (\Exception $e) {
                    Log::error("Error creating or finding company: {$e->getMessage()}");
                }
            } else {
                Log::warning("Skipping item $key because ticker is not set or empty");
            }
        }
    }    
}