<?php

function getLowPriceFromDashRange($lowHighString, $default = '-'): string {
    if (!$lowHighString) return $default;
    $result = explode("-", $lowHighString);
    if (count($result) < 2)
        return '&mdash;';
    return $result[1] ? $result[1] : $default;
}

function getHighPriceFromDashRange($lowHighString, $default = '-'): string {
    if (!$lowHighString) return $default;
    $result = explode("-", $lowHighString);
    if (count($result) < 2)
        return '&mdash;';
    return $result[0] ? $result[0] : $default;
}

function getSiteNameFromUrl($url, $default = '-') {
    if (!$url || !is_string($url)) return $default;
    $result = preg_replace("~^https?\:/~", "", $url);
    $result = trim($result, " /\\");
    if (strlen($result) > 15)
        $result = substr($result, 0, 15) . '...';
    return $result;
}
