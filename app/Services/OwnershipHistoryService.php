<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Arr;

class OwnershipHistoryService
{
    public static function setCompany(string $ticker, bool $clearIfChanged = true): void
    {        
        if($clearIfChanged && static::hasCompany() && static::getCompany() !== $ticker) {
            static::clear();
        }
        
        session()->put('ownership-history.company', $ticker);
    }

    public static function hasCompany(): bool
    {
        return session()->has('ownership-history.company');
    }

    public static function getCompany(): string
    {
        return session('ownership-history.company', Company::DEFAULT_TICKER);
    }

    public static function push(array $data): void
    {
        $data['url'] = rtrim(parse_url($data['url'], PHP_URL_PATH), '/');

        // Dont open new tab if the url is the one that lead to the rabbit hole
        if (route('company.ownership', static::getCompany(), false) === $data['url']) {
            return;
        }

        $items = static::get();

        if (Arr::where($items, fn ($item) => $item['url'] === $data['url'])) {
            return;
        }

        $items = array_merge([$data], $items);

        session()->put('ownership-history.items', $items);
    }

    public static function get(?string $requestUrl = null): array
    {
        $history = session('ownership-history.items', []);
        $requestUrl = $requestUrl ? rtrim(parse_url($requestUrl, PHP_URL_PATH), '/') : null;

        return Arr::map($history, fn ($item) => [
            'name' => $item['name'],
            'url' => $item['url'],
            'active' => $requestUrl && $requestUrl === $item['url'],
        ]);
    }

    public static function remove($url): void
    {
        $history = array_filter(static::get(), function ($historyItem) use ($url) {
            return $historyItem['url'] !== $url;
        });

        session()->put('ownership-history.items', array_values($history));
    }

    public static function clear(): void
    {
        session()->forget('ownership-history.items');
    }
}
