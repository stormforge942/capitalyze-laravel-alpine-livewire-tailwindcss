<?php

namespace App\Services;

use Illuminate\Support\Arr;

class OwnershipHistoryService
{
    public static function clear(): void
    {
        session()->forget('ownership-history');
    }

    public static function push(array $data)
    {
        if (
            $data['type'] === 'company' &&
            !count(session('ownership-history.items', []))
        ) {
            session()->put('ownership-history.companyUrl', $data['url']);
            return;
        }

        $data['url'] = rtrim(parse_url($data['url'], PHP_URL_PATH), '/');

        if (Arr::where(static::get(), fn ($item) => $item['url'] === $data['url'])) {
            return;
        }

        session()->push('ownership-history.items', $data);
    }

    public static function get()
    {
        $history = session('ownership-history.items', []);

        return Arr::map($history, fn ($item) => [
            'name' => $item['name'],
            'type' => $item['type'],
            'url' => $item['url'],
            'active' => rtrim(parse_url(request()->url(), PHP_URL_PATH), '/') === $item['url'],
        ]);
    }

    public static function remove($url): ?array
    {
        $history = static::get();
        $history = Arr::where($history, function ($historyItem) use ($url) {
            return $historyItem['url'] !== $url;
        });

        session()->put('ownership-history.items', $history);

        return Arr::last($history);
    }

    public static function getCompanyUrl(): ?string
    {
        return session('ownership-history.companyUrl');
    }
}
