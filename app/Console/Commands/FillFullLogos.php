<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FillFullLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:images-s3-full-logo {filter?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch logo urls from api-ninjas.com and fill them on s3';

    private function checkIfExists($ticker)
    {
        return Storage::disk('s3')->exists("company_logos/full/{$ticker}.png");
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filter = $this->argument('filter');

        if ($filter) {
            list($startChar, $endChar) = explode('-', $filter);
        } else {
            $startChar = $endChar = null;
        }

        $keys = [
            'dGgmvH6ZfGFx2flly4AgDg==Ao8aBJkTpJlnzTYh',
            'MO2LmRH9vx1oerEBFkmWGw==ubX386o4cPhLyCB4',
            'jgVt4iej0ESpqcuOB62fYg==H2jmhfS1Nx8rvH38',
            'vFUWXmKacCUvtNiRNM15uQ==IywYfvl3aURjR0pW',
            'Io4H4OGc0mfbWgIKr0cTJQ==qXtZvkRv7M4Xxqur'
        ];

        $companies = CompanyProfile::query()
            ->select('symbol')
            ->when($startChar, function ($query) use ($startChar) {
                return $query->where('symbol', '>=', $startChar);
            })
            ->when($endChar, function ($query) use ($endChar) {
                return $query->where('symbol', '<=', $endChar . 'z');
            })
            ->get();

        $keyIndex = 0;

        $companies->map(function ($company) use ($keys, &$keyIndex) {
            $token = $keys[$keyIndex];
            $symbol = $company->symbol;

            // Check if already exists
            if ($this->checkIfExists($symbol)) {
                Log::info("Logo of {$symbol} already exists");
            } else {
                $sourceLink = "https://api.api-ninjas.com/v1/logo?ticker={$symbol}";
                $response = Http::withHeaders([
                    'X-Api-Key' => $token,
                ])->get($sourceLink);

                $keyIndex = ($keyIndex + 1) % 5;

                if ($response->successful()) {
                    $imgData = $response->json();
                    if (count($imgData) > 0) {
                        $imgUrl = $imgData[0]['image'];
                        $imgResponse = Http::get($imgUrl);

                        if ($imgResponse->successful()) {
                            $fileName = $symbol . '.png';
                            $filePath = '/company_logos/full/' . $fileName;
                            Storage::disk('s3')->put($filePath, $imgResponse->body());

                            Log::info("Stored logo of {$symbol} successfully");
                        } else {
                            Log::error("Logo of {$symbol} doesn't exist");
                        }
                    } else {
                        Log::error("Logo of {$symbol} doesn't exist");
                    }
                } else {
                    Log::error("Logo of {$symbol} doesn't exist");
                }
            }
        });

        return Command::SUCCESS;
    }
}
