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

function getFilingsSummaryTab(){
    return $data = [
        [
            'name' => 'All Documents',
            'value' => 'all-documents',
            'params'=> [],

        ],
        [
            'name' => 'Financials',
            'value' => 'financials',
            'params'=> ['NT 10-K','10-KT/A','10-KT','10-K','10-Q','10-QT/A','NT 10-Q/A','20-F','NT 20-F','20-F/A','40-F','40-F/A','1-K/A','1-K','1-SA','1-SA/A','18-K','18-K/A','N-CEN/A','N-CEN','N-30D','N-CSRS','N-CSRS/A','N-CSRS','NT 11-K','NT 11-K/A','QRTLYRPT','ANNLRPT'],

        ],
        [
            'name' => 'News',
            'value' => 'news',
            'params' => ['8-K','8-K/A','1-U','1-U/A','6-K','6-K/A','8-K12G3','8-K12G3/A','8-K12B','8-K12B/A']
        ],
        [
            'name' => 'Registration and Prospectus',
            'value' => 'registrations-and-prospectuses',
            'params' => ['10-12G','10-12G/A','10-12B','10-12B/A','20FR12B/A','20FR12B','18-12B','20FR12G/A','20FR12G','40-24B2','40FR12B','40FR12B/A','40FR12G','40FR12G/A','424A','424B1','424B2','424B3','424B4','424B5','424B7','424B8','424H','425','485APOS','485BPOS','485BXT','487','497','497J','497K','8-A12B','8-A12B/A','8-A12G','8-A12G/A','AW','AW WD','DEL AM','DRS','F-1','F-1/A','F-10','F-10/A','F-10EF','F-10POS','F-3','F-3/A','F-3ASR','F-3D','F-3DPOS','F-3MEF','F-4','F-4/A','F-4 POS','F-4MEF','F-6','F-6/A','F-6 POS','F-6EF','F-7','F-7 POS','F-8','F-8/A','F-8 POS','F-80','F-80/A','F-80POS','F-9','F-9/A','F-9 POS','F-N','F-N/A','F-X','F-X/A','FWP','N-2','N-2/A','POS AM','POS EX','POS462B','POS462C','POSASR','RW','RW WD','S-1','S-1/A','S-11','S-11/A','S-11MEF','S-1MEF','S-20','S-3','S-3/A','S-3ASR','S-3D','S-3DPOS','S-3MEF','S-4','S-4/A','S-4 POS','S-4EF','S-4MEF','S-6','S-8','S-8 POS','S-B','S-B/A','S-BMEF','SF-1','SF-1/A','SF-3','SUPPL','UNDER']
        ],
        [
            'name' => 'Proxy Materials',
            'value' => 'proxy-materials',
            'params' => ['ARS','ARS/A','DEF 14A','DEF 14C','DEFA14A','DEFA14C','DEFC14A','DEFC14C','DEFM14A','DEFM14C','DEFN14A','DEFR14A','DEFR14C','DFAN14A','DFRN14A','PRE 14A','PRE 14C','PREC14A','PREC14C','PREM14A','PREM14C','PREN14A','PRER14A','PRER14C','PRRN14A','PX14A6G','PX14A6N','SC 14N','SC 14N/A']
        ],
        [
            'name' => 'Ownership',
            'value' => 'ownership',
            'params' =>['3','4','5','3/A','4/A','5/A','SC 13D','SC 13G','SC14D1F','SC 13D/A','SC 13G/A','SC14D1F/A','144','144/A','13F-HR','13F-HR/A']
        ],
        [
            'name' => 'Insider Equity',
            'value' => 'insider-equity',
            'params' => ['3','4','5', '144']
        ],
        [
            'name' => 'Others',
            'value' => 'other',
            'params' => ['C-AR/A','N-1A','40-8F-2/A','305B2/A','APP WD','NPORT-EX/A','SC TO-I','SB-1/A','NT-NSAR','SC13E4F/A','NPORT-EX','SP 15D2','POS AMC','T-3','15-12B/A','CORRESP','1-E','SC TO-I/A','N-54A/A','15-12G','497H2','15F-12G/A','40-APP/A','15-15D','NSAR-U','10SB12G/A','SC 14D9/A','APP WD/A','U-1/A','U5A/A','S-2/A','SB-2/A','40-APP','35-CERT/A','15-15D/A','IRANNOTICE','40-33','U-13-60','N-6F','N-8F ORDR','POS 8C','15-12B','DOS','S-2','40-17G','U-3A-2/A','N-6F/A','MA-I','424I','N-8F/A','DRS/A','CB','1-A','F-2','N-Q/A','N-8A/A','253G1','REVOKED','10SB12B/A','10-D','253G3','SC14D9C','N-23C-1/A','NPORT-P/A','1-A POS','15F-12G','SBSE-C','D','U5B','U5S','8F-2 NTC','SB-2MEF','SC TO-T','SC 13E3','1-A/A','U-3A-2','U-13-60/A','DOSLTR','25/A','25-NSE','N-23C3A/A','CT ORDER','N-5/A','U-1','N-CSR','SB-2','15F-15D','SC 14D9','NT 10-Q','N-14 8C/A','N-14/A','40-8B25','SB-1','N-CSR/A','11-K/A','U-57','SC TO-C','N-2ASR','N-5','NPORT-P','T-3/A','N-1A/A','305B2','SC 14F1/A','40-6B','N-23C-2/A','QUALIF','DRSLTR','8-K15D5','N-2 POSASR','U5S/A','U-9C-3/A','1-A-W/A','10-K/A','1-Z-W','253G2','ABS-15G','N-14','C-TR','N-8A','11-K','U-9C-3','POS AMI','N-14 8C','40-6B/A','SBSE-A','S-2MEF','F-4EF','MA-I/A','8F-2 ORDR','6B NTC','1-A-W','NRSRO-CE','35-CERT','40-17F2','N-2MEF','N-23C3C','486BPOS','13F-NT/A','N-30B-2','10-QT','U-7D/A','40-17F1','SC 13E3/A','2-E','N-23C-2','253G4','10SB12B','1-Z/A','CB/A','C','40-17GCS','N-8F','15-12G/A','N-PX/A','40-17G/A','10-Q/A','10-D/A','10QSB','486APOS','6B ORDR','N-8F NTC','SC13E4F','SC 14F1','10KSB','U-12-IA','ABS-15G/A','NT 20-F/A','497AD','EFFECT','NT-NCEN','F-2/A','SC14D9F/A','NT-NSAR/A','15F-12B/A','N-14MEF','24F-2NT','40-8F-2','SBSE-A/A','40-33/A','25','CERT','C-W','N-30D/A','SD/A','U-57/A','N-Q','N-8B-2/A','11-KT','F-1MEF','SD','40-17F2/A','15F-15D/A','N-23C-1','13F-NT','APP NTC','U-33-S','10KSB/A','N-PX','U-6B-2','25-NSE/A','NT-NCSR','N-23C3A','NSAR-U/A','C-U','10SB12G','DOS/A','SC TO-T/A','C/A','U-12-IB','APP WDG','C-AR','10QSB/A','15F-12B','NT-NCSR/A','NT 10-K/A','SC 13E1','N-54C','486BXT','N-54A','D/A','N-23C3C/A','APP ORDR','U5A','1-Z']
        ]
    ];
}

function falingsSummaryTabFilteredValue($val){
    $data = getFilingsSummaryTab();
    return collect($data)->where('value', $val)->first();
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
