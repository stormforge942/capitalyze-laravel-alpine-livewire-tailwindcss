<?php

use Illuminate\Support\Str;

function getLowPriceFromDashRange($lowHighString, $default = '-'): string
{
    if (!$lowHighString) return $default;
    $result = explode("-", $lowHighString);
    if (count($result) < 2)
        return '&mdash;';
    return $result[1] ? $result[1] : $default;
}

function getHighPriceFromDashRange($lowHighString, $default = '-'): string
{
    if (!$lowHighString) return $default;
    $result = explode("-", $lowHighString);
    if (count($result) < 2)
        return '&mdash;';
    return $result[0] ? $result[0] : $default;
}

function getSiteNameFromUrl($url, $default = '-')
{
    if (!$url) return $default;

    return Str::limit(parse_url($url)['host'] ?? $default, 15);
}
