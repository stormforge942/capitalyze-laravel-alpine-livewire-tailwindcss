<?php
 
namespace App\Console\Commands;
 
use App\Models\Company;
use Illuminate\Console\Command;
 
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

        foreach($json as $item => $value) {            
            $company = Company::firstOrCreate(
                ['cik' => $value->cik_str], 
                ['ticker' => $value->ticker,'name' => $value->title]
            );
        }
    }
}