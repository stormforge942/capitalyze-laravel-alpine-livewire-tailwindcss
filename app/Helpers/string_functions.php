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

function niceNumber($n)
{
    // first strip any formatting;
    $n = (0 + str_replace(",", "", $n));
    // is this a number?
    if (!is_numeric($n)) return false;
    if ($n > 1000000000000) return round(($n / 1000000000000), 2) . ' T';
    elseif ($n > 1000000000) return round(($n / 1000000000), 2) . ' B';
    elseif ($n > 1000000) return round(($n / 1000000), 2) . ' M';
    elseif ($n > 1000) return round(($n / 1000), 2) . ' K';
    return number_format($n);
}

function escapeJSText(string $string)
{
    return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
}

function asTabs(array $tabs)
{
    return array_map(function ($tab) {
        return [
            'title' => $tab::title(),
            'key' => $tab::key(),
        ];
    }, $tabs);
}

function redIfNegative($value, ?callable $formatter = null)
{
    if (!is_numeric($value)) return e($value);

    if ($value < 0) {
        if ($formatter) {
            $formattedValue = $formatter(-1 * $value);
        }

        return '<span class="text-red">(' . $formattedValue . ')</span>';
    }

    if ($formatter) {
        return $formatter($value);
    }

    return $value;
}

function custom_number_format($number, $decimals = 2, $dec_point = '.', $thousands_sep = ',')
{
    if (!is_numeric($number)) return $number;

    $number = number_format($number, $decimals, $dec_point, $thousands_sep);
    return $number;
}
