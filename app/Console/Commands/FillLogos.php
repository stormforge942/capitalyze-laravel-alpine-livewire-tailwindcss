<?php

namespace App\Console\Commands;

use App\Models\Navbar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FillLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:images-s3-logo {filter?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all logos from logo.dev and fill them on s3';

    private function getDomainFromWebsite($website)
    {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);
        return $domain;
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
            'pk_dn8ZGd16Tr2UXskby36kmA',
            'pk_UAkwNfK_RbOyAeHi16KyIg',
            'pk_bah_P6riRQGd-0FtK32OfQ',
            'pk_FCKvpzTERz2YrEr-xpIWcA',
            'pk_OwtAKyiyRcGVGGGukVihtg'
        ];

        $companies = CompanyProfile::query()
            ->select('symbol', 'website')
            ->when($startChar, function ($query) use ($startChar) {
                return $query->where('symbol', '>=', $startChar);
            })
            ->when($endChar, function ($query) use ($endChar) {
                return $query->where('symbol', '<=', $endChar . 'z');
            })
            ->get();

        $keyIndex = 0;

        $companies->map(function ($company) use ($keys, &$keyIndex) {
            if (! $company->website) return;

            $symbol = $company->symbol;
            $domain = $this->getDomainFromWebsite($company->website);
            $sourceLink = "https://img.logo.dev/{$domain}?token={$keys[$keyIndex]}";

            $response = Http::get($sourceLink);

            if ($response->ok()) {
                $contentType = $response->header('Content-Type');

                if (Str::startsWith($contentType, 'image/')) {
                    $fileName = $symbol . '.png';
                    $filePath = '/company_logos/' . $fileName;
                    Storage::disk('s3')->put($filePath, $response->body());

                    Log::info("Stored logo of {$symbol} successfully");
                }
            } else {
                Log::error("Logo of {$symbol} doesn't exist");
            }

            $keyIndex = ($keyIndex + 1) % 5;
        });

        return Command::SUCCESS;
    }
}