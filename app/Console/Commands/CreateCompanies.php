<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;
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


    public function handle()
    {
        $url = 'https://www.sec.gov/files/company_tickers.json';

        // Use Laravel's HTTP client to get the JSON with custom headers
        $response = Http::withHeaders([
            'User-Agent' => 'Sample Company Name mgmt@capitalyze.com',
            'Accept-Encoding' => 'gzip, deflate',
            'Host' => 'www.sec.gov'
        ])->get($url);

        // Check if the request was successful
        if ($response->successful()) {
            $json = $response->json();

            foreach($json as $key => $value) {
                if (isset($value["ticker"]) && !empty($value["ticker"])) {
                    Log::debug("Ticker is set and not empty: {$value["ticker"]}");
                    try {
                        $company = Company::updateOrCreate(
                            ['cik' => $value["cik_str"]],
                            ['ticker' => $value["ticker"], 'name' => $value["title"]]
                        );
                    } catch (\Exception $e) {
                        Log::error("Error creating or finding company: {$e->getMessage()}");
                    }
                } else {
                    Log::warning("Skipping item $key because ticker is not set or empty");
                }
            }

            $this->info('Companies imported successfully!');
        } else {
            Log::error("Failed to fetch data from SEC: " . $response->body());
            $this->error('Failed to import companies!');
        }
    }

}
