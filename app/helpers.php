<?php

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

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
    $n = (0 + str_replace(",", "", $n));

    if (!is_numeric($n)) return false;

    if ($n < 0) return '-' . niceNumber(abs($n));

    if ($n > 1000000000000) return round(($n / 1000000000000), 2) . ' T';
    elseif ($n > 1000000000) return round(($n / 1000000000), 2) . ' B';
    elseif ($n > 1000000) return round(($n / 1000000), 2) . ' M';
    elseif ($n > 1000) return round(($n / 1000), 2) . ' K';

    return number_format($n);
}

function getFilingsSummaryTab()
{
    return [
        [
            'name' => 'Financials',
            'value' => 'financials',
            'params' => ['NT 10-K', '10-KT/A', '10-KT', '10-K', '10-Q', '10-QT/A', 'NT 10-Q/A', '20-F', 'NT 20-F', '20-F/A', '40-F', '40-F/A', '1-K/A', '1-K', '1-SA', '1-SA/A', '18-K', '18-K/A', 'N-CEN/A', 'N-CEN', 'N-30D', 'N-CSRS', 'N-CSRS/A', 'N-CSRS', 'NT 11-K', 'NT 11-K/A', 'QRTLYRPT', 'ANNLRPT'],

        ],
        [
            'name' => 'News',
            'value' => 'news',
            'params' => ['8-K', '8-K/A', '1-U', '1-U/A', '6-K', '6-K/A', '8-K12G3', '8-K12G3/A', '8-K12B', '8-K12B/A']
        ],
        [
            'name' => 'Registration and Prospectus',
            'value' => 'registrations-and-prospectuses',
            'params' => ['10-12G', '10-12G/A', '10-12B', '10-12B/A', '20FR12B/A', '20FR12B', '18-12B', '20FR12G/A', '20FR12G', '40-24B2', '40FR12B', '40FR12B/A', '40FR12G', '40FR12G/A', '424A', '424B1', '424B2', '424B3', '424B4', '424B5', '424B7', '424B8', '424H', '425', '485APOS', '485BPOS', '485BXT', '487', '497', '497J', '497K', '8-A12B', '8-A12B/A', '8-A12G', '8-A12G/A', 'AW', 'AW WD', 'DEL AM', 'DRS', 'F-1', 'F-1/A', 'F-10', 'F-10/A', 'F-10EF', 'F-10POS', 'F-3', 'F-3/A', 'F-3ASR', 'F-3D', 'F-3DPOS', 'F-3MEF', 'F-4', 'F-4/A', 'F-4 POS', 'F-4MEF', 'F-6', 'F-6/A', 'F-6 POS', 'F-6EF', 'F-7', 'F-7 POS', 'F-8', 'F-8/A', 'F-8 POS', 'F-80', 'F-80/A', 'F-80POS', 'F-9', 'F-9/A', 'F-9 POS', 'F-N', 'F-N/A', 'F-X', 'F-X/A', 'FWP', 'N-2', 'N-2/A', 'POS AM', 'POS EX', 'POS462B', 'POS462C', 'POSASR', 'RW', 'RW WD', 'S-1', 'S-1/A', 'S-11', 'S-11/A', 'S-11MEF', 'S-1MEF', 'S-20', 'S-3', 'S-3/A', 'S-3ASR', 'S-3D', 'S-3DPOS', 'S-3MEF', 'S-4', 'S-4/A', 'S-4 POS', 'S-4EF', 'S-4MEF', 'S-6', 'S-8', 'S-8 POS', 'S-B', 'S-B/A', 'S-BMEF', 'SF-1', 'SF-1/A', 'SF-3', 'SUPPL', 'UNDER']
        ],
        [
            'name' => 'Proxy Materials',
            'value' => 'proxy-materials',
            'params' => ['ARS', 'ARS/A', 'DEF 14A', 'DEF 14C', 'DEFA14A', 'DEFA14C', 'DEFC14A', 'DEFC14C', 'DEFM14A', 'DEFM14C', 'DEFN14A', 'DEFR14A', 'DEFR14C', 'DFAN14A', 'DFRN14A', 'PRE 14A', 'PRE 14C', 'PREC14A', 'PREC14C', 'PREM14A', 'PREM14C', 'PREN14A', 'PRER14A', 'PRER14C', 'PRRN14A', 'PX14A6G', 'PX14A6N', 'SC 14N', 'SC 14N/A']
        ],
        [
            'name' => 'Ownership',
            'value' => 'ownership',
            'params' => ['3', '4', '5', '3/A', '4/A', '5/A', 'SC 13D', 'SC 13G', 'SC14D1F', 'SC 13D/A', 'SC 13G/A', 'SC14D1F/A', '144', '144/A', '13F-HR', '13F-HR/A']
        ],
        [
            'name' => 'Others',
            'value' => 'other',
            'params' => ['C-AR/A', 'N-1A', '40-8F-2/A', '305B2/A', 'APP WD', 'NPORT-EX/A', 'SC TO-I', 'SB-1/A', 'NT-NSAR', 'SC13E4F/A', 'NPORT-EX', 'SP 15D2', 'POS AMC', 'T-3', '15-12B/A', 'CORRESP', '1-E', 'SC TO-I/A', 'N-54A/A', '15-12G', '497H2', '15F-12G/A', '40-APP/A', '15-15D', 'NSAR-U', '10SB12G/A', 'SC 14D9/A', 'APP WD/A', 'U-1/A', 'U5A/A', 'S-2/A', 'SB-2/A', '40-APP', '35-CERT/A', '15-15D/A', 'IRANNOTICE', '40-33', 'U-13-60', 'N-6F', 'N-8F ORDR', 'POS 8C', '15-12B', 'DOS', 'S-2', '40-17G', 'U-3A-2/A', 'N-6F/A', 'MA-I', '424I', 'N-8F/A', 'DRS/A', 'CB', '1-A', 'F-2', 'N-Q/A', 'N-8A/A', '253G1', 'REVOKED', '10SB12B/A', '10-D', '253G3', 'SC14D9C', 'N-23C-1/A', 'NPORT-P/A', '1-A POS', '15F-12G', 'SBSE-C', 'D', 'U5B', 'U5S', '8F-2 NTC', 'SB-2MEF', 'SC TO-T', 'SC 13E3', '1-A/A', 'U-3A-2', 'U-13-60/A', 'DOSLTR', '25/A', '25-NSE', 'N-23C3A/A', 'CT ORDER', 'N-5/A', 'U-1', 'N-CSR', 'SB-2', '15F-15D', 'SC 14D9', 'NT 10-Q', 'N-14 8C/A', 'N-14/A', '40-8B25', 'SB-1', 'N-CSR/A', '11-K/A', 'U-57', 'SC TO-C', 'N-2ASR', 'N-5', 'NPORT-P', 'T-3/A', 'N-1A/A', '305B2', 'SC 14F1/A', '40-6B', 'N-23C-2/A', 'QUALIF', 'DRSLTR', '8-K15D5', 'N-2 POSASR', 'U5S/A', 'U-9C-3/A', '1-A-W/A', '10-K/A', '1-Z-W', '253G2', 'ABS-15G', 'N-14', 'C-TR', 'N-8A', '11-K', 'U-9C-3', 'POS AMI', 'N-14 8C', '40-6B/A', 'SBSE-A', 'S-2MEF', 'F-4EF', 'MA-I/A', '8F-2 ORDR', '6B NTC', '1-A-W', 'NRSRO-CE', '35-CERT', '40-17F2', 'N-2MEF', 'N-23C3C', '486BPOS', '13F-NT/A', 'N-30B-2', '10-QT', 'U-7D/A', '40-17F1', 'SC 13E3/A', '2-E', 'N-23C-2', '253G4', '10SB12B', '1-Z/A', 'CB/A', 'C', '40-17GCS', 'N-8F', '15-12G/A', 'N-PX/A', '40-17G/A', '10-Q/A', '10-D/A', '10QSB', '486APOS', '6B ORDR', 'N-8F NTC', 'SC13E4F', 'SC 14F1', '10KSB', 'U-12-IA', 'ABS-15G/A', 'NT 20-F/A', '497AD', 'EFFECT', 'NT-NCEN', 'F-2/A', 'SC14D9F/A', 'NT-NSAR/A', '15F-12B/A', 'N-14MEF', '24F-2NT', '40-8F-2', 'SBSE-A/A', '40-33/A', '25', 'CERT', 'C-W', 'N-30D/A', 'SD/A', 'U-57/A', 'N-Q', 'N-8B-2/A', '11-KT', 'F-1MEF', 'SD', '40-17F2/A', '15F-15D/A', 'N-23C-1', '13F-NT', 'APP NTC', 'U-33-S', '10KSB/A', 'N-PX', 'U-6B-2', '25-NSE/A', 'NT-NCSR', 'N-23C3A', 'NSAR-U/A', 'C-U', '10SB12G', 'DOS/A', 'SC TO-T/A', 'C/A', 'U-12-IB', 'APP WDG', 'C-AR', '10QSB/A', '15F-12B', 'NT-NCSR/A', 'NT 10-K/A', 'SC 13E1', 'N-54C', '486BXT', 'N-54A', 'D/A', 'N-23C3C/A', 'APP ORDR', 'U5A', '1-Z']
        ]
    ];
}

function falingsSummaryTabFilteredValue($val)
{
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
    if (!$formatter) {
        $formatter = fn($val) => $val;
    }

    if (is_array($value) && Arr::has($value, ['value', 'formatted'])) {
        if ($value['value'] < 0) {
            return '<span class="text-red">(' . ltrim($value['formatted'], "-") . ')</span>';
        }

        return $value['formatted'];
    }

    if (!is_numeric(str_replace(',', '', $value))) return e($value);

    $value = str_replace(',', '', $value);

    if ($value < 0) {
        $value = abs($value);
        return '<span class="text-red">(' . $formatter($value) . ')</span>';
    }

    return $formatter($value);
}

function custom_number_format($number, $decimals = 2, $dec_point = '.', $thousands_sep = ',')
{
    if (!is_numeric($number)) return $number;

    $number = number_format($number, $decimals, $dec_point, $thousands_sep);
    return $number;
}

/**
 * generate a random dark color such that white text can be read on it
 */
function random_color(): string
{
    $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    $r = hexdec(substr($color, 1, 2));
    $g = hexdec(substr($color, 3, 2));
    $b = hexdec(substr($color, 5, 2));
    $luminance = ($r * 0.299) + ($g * 0.587) + ($b * 0.114);
    if ($luminance > 150) {
        return random_color();
    }

    return $color;
}

function calculateYoyChange(array $values, array $dates): array
{
    $change = [];

    $lastVal = 0;
    foreach ($dates as $date) {
        $value = $values[$date] ?? 0;

        $change[$date] = $lastVal
            ? (($value / $lastVal) - 1) * 100
            : 0;

        $lastVal = $value;
    }

    return $change;
}

function formatNiceNumber($number)
{
    $number = (float) $number;

    $suffix = ['', 'k', 'M', 'B', 'T'];

    $suffixIndex = floor(log10(abs($number)) / 3);

    $formattedNumber = number_format($number / pow(1000, $suffixIndex), 1) . $suffix[$suffixIndex];

    return $formattedNumber;
}

function format_overview_numbers($value)
{
    if (is_null($value)) return '-';

    if (!is_numeric($value)) return $value;

    $val = floatval($value);

    $val = number_format($val / 1000000, 1);

    $val = $val;

    if ($val >= 0) {
        return $val;
    }

    $val = ltrim($val, "-");
    return "<span class=\"text-red\">({$val})</span>";
}

function sticky_table_class($value): string
{
    $classes = [
        'Top Row' => ['sticky-row'],
        'First Column' => ['sticky-column'],
        'Top Row & First Column' => ['sticky-row', 'sticky-column']
    ];

    return 'sticky-table ' . implode(' ', $classes[$value] ?? []);
}

function user_decimal_places($default = 1)
{
    return data_get(auth()->user(), 'settings.decimalPlaces', $default);
}

function generate_quarter_options(Carbon $start, Carbon $end, string $suffix = '')
{
    $quarters = [];

    $startYear = $start->year;
    $startQuarter = $start->quarter;
    $currentYear = $end->year;
    $currentQuarter = $end->quarter;
    $currentDay = $end->day;
    $quarterEndDates = [
        1 => '-03-31',
        2 => '-06-30',
        3 => '-09-30',
        4 => '-12-31',
    ];
    $quarterEndDays = [
        1 => 31,
        2 => 30,
        3 => 30,
        4 => 31,
    ];

    for ($year = $startYear; $year <= $currentYear; $year++) {
        $startQuarter = ($year == $startYear) ? $startQuarter : 1;
        for ($quarter = $startQuarter; $quarter <= 4; $quarter++) {
            if ($year == $currentYear && $quarter > $currentQuarter) {
                break;
            }
            // Don't include the current quarter if it's not over yet
            if ($year == $currentYear && $quarter == $currentQuarter && $currentDay < $quarterEndDays[$quarter]) {
                continue;
            }
            $quarterEnd = $year . $quarterEndDates[$quarter];
            $quarterText = 'Q' . $quarter . ' ' . $year . ($suffix ? ' ' . $suffix : '');
            $quarters[$quarterEnd] = $quarterText;
        }
    }

    return array_reverse($quarters, true);
}

function generate_month_options(Carbon $start, Carbon $end, string $suffix = '')
{
    $months = [];

    $startYear = $start->year;
    $startMonth = $start->month;
    $currentYear = $end->year;
    $currentMonth = $end->month;

    for ($year = $startYear; $year <= $currentYear; $year++) {
        $startMonth = ($year == $startMonth) ? $startMonth : 1;
        for ($month = $startMonth; $month <= 12; $month++) {
            if ($year == $currentYear && $month > $currentMonth) {
                break;
            }
            // Don't include the current quarter if it's not over yet
            if ($year == $currentYear && $month == $currentMonth) {
                continue;
            }
            $monthText = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            $months[$monthText] = $monthText;
        }
    }

    return array_reverse($months, true);
}

function getOrdinalSuffix($day)
{
    if ($day > 3 && $day < 21) return 'th'; // 11th, 12th, 13th, etc.
    switch ($day % 10) {
        case 1:
            return 'st';
        case 2:
            return 'nd';
        case 3:
            return 'rd';
        default:
            return 'th';
    }
}

function formatDate($date)
{
    $months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    $day = (int) $date->format('j');
    $month = $months[(int) $date->format('n') - 1];
    $year = $date->format('Y');

    $ordinalSuffix = getOrdinalSuffix($day);

    return "{$day}{$ordinalSuffix} {$month}, {$year}";
}

function formatTime($date)
{
    $hours = (int) $date->format('H');
    $minutes = (int) $date->format('i');
    $ampm = $hours >= 12 ? 'pm' : 'am';
    $hours = $hours % 12;
    $hours = $hours ? $hours : 12; // the hour '0' should be '12'
    $strMinutes = $minutes < 10 ? '0' . $minutes : $minutes;

    return "{$hours}:{$strMinutes}{$ampm}";
}

function formatDateTime($date, $middle = ' ')
{
    $time = formatTime($date);
    return formatDate($date) . $middle . $time . ' CET';
}

function getCountries()
{
    return [
        'Afghanistan',
        'Albania',
        'Algeria',
        'Andorra',
        'Angola',
        'Antigua and Barbuda',
        'Argentina',
        'Armenia',
        'Australia',
        'Austria',
        'Azerbaijan',
        'Bahamas',
        'Bahrain',
        'Bangladesh',
        'Barbados',
        'Belarus',
        'Belgium',
        'Belize',
        'Benin',
        'Bhutan',
        'Bolivia',
        'Bosnia and Herzegovina',
        'Botswana',
        'Brazil',
        'Brunei',
        'Bulgaria',
        'Burkina Faso',
        'Burundi',
        'Cabo Verde',
        'Cambodia',
        'Cameroon',
        'Canada',
        'Central African Republic',
        'Chad',
        'Chile',
        'China',
        'Colombia',
        'Comoros',
        'Congo (Congo-Brazzaville)',
        'Costa Rica',
        'Croatia',
        'Cuba',
        'Cyprus',
        'Czechia (Czech Republic)',
        'Denmark',
        'Djibouti',
        'Dominica',
        'Dominican Republic',
        'Ecuador',
        'Egypt',
        'El Salvador',
        'Equatorial Guinea',
        'Eritrea',
        'Estonia',
        'Eswatini (fmr. "Swaziland")',
        'Ethiopia',
        'Fiji',
        'Finland',
        'France',
        'Gabon',
        'Gambia',
        'Georgia',
        'Germany',
        'Ghana',
        'Greece',
        'Grenada',
        'Guatemala',
        'Guinea',
        'Guinea-Bissau',
        'Guyana',
        'Haiti',
        'Honduras',
        'Hungary',
        'Iceland',
        'India',
        'Indonesia',
        'Iran',
        'Iraq',
        'Ireland',
        'Israel',
        'Italy',
        'Jamaica',
        'Japan',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kiribati',
        'Kuwait',
        'Kyrgyzstan',
        'Laos',
        'Latvia',
        'Lebanon',
        'Lesotho',
        'Liberia',
        'Libya',
        'Liechtenstein',
        'Lithuania',
        'Luxembourg',
        'Madagascar',
        'Malawi',
        'Malaysia',
        'Maldives',
        'Mali',
        'Malta',
        'Marshall Islands',
        'Mauritania',
        'Mauritius',
        'Mexico',
        'Micronesia',
        'Moldova',
        'Monaco',
        'Mongolia',
        'Montenegro',
        'Morocco',
        'Mozambique',
        'Myanmar (formerly Burma)',
        'Namibia',
        'Nauru',
        'Nepal',
        'Netherlands',
        'New Zealand',
        'Nicaragua',
        'Niger',
        'Nigeria',
        'North Korea',
        'North Macedonia',
        'Norway',
        'Oman',
        'Pakistan',
        'Palau',
        'Palestine State',
        'Panama',
        'Papua New Guinea',
        'Paraguay',
        'Peru',
        'Philippines',
        'Poland',
        'Portugal',
        'Qatar',
        'Romania',
        'Russia',
        'Rwanda',
        'Saint Kitts and Nevis',
        'Saint Lucia',
        'Saint Vincent and the Grenadines',
        'Samoa',
        'San Marino',
        'Sao Tome and Principe',
        'Saudi Arabia',
        'Senegal',
        'Serbia',
        'Seychelles',
        'Sierra Leone',
        'Singapore',
        'Slovakia',
        'Slovenia',
        'Solomon Islands',
        'Somalia',
        'South Africa',
        'South Korea',
        'South Sudan',
        'Spain',
        'Sri Lanka',
        'Sudan',
        'Suriname',
        'Sweden',
        'Switzerland',
        'Syria',
        'Taiwan',
        'Tajikistan',
        'Tanzania',
        'Thailand',
        'Timor-Leste',
        'Togo',
        'Tonga',
        'Trinidad and Tobago',
        'Tunisia',
        'Turkey',
        'Turkmenistan',
        'Tuvalu',
        'Uganda',
        'Ukraine',
        'United Arab Emirates',
        'United Kingdom',
        'United States of America',
        'Uruguay',
        'Uzbekistan',
        'Vanuatu',
        'Venezuela',
        'Vietnam',
        'Yemen',
        'Zambia',
        'Zimbabwe'
    ];
}

function confirmPassword(User $user, string $password): bool
{
    $isValid = Hash::check($password, $user->password);

    if ($isValid) {
        session(['auth.password_confirmed_at' => time()]);
    }

    return $isValid;
}

function isPasswordConfirmed(): bool
{
    $period = config('auth.password_timeout', 900);
    return (time() - session('auth.password_confirmed_at', 0)) < $period;
}

function makeFormulaDescription($arguments, $result, $date, $metric, $type): array
{
    $title = match ($type) {
        'yoy_change' => 'Evaluation for % Change YoY/',
        'net_debt_by_capital' => 'Evaluation for % Net Debt / Capital/',
        'of_total_revenue' => 'Evaluation for % of Total Revenue/',
        'of_total_expenses' => 'Evaluation for % of Total Expenses/',
        'of_ebitda' => 'Evaluation for % of EBITDA/',
        'of_total_capital' => 'Evaluation for % of Total Capital/',
        'of_total_sources' => 'Evaluation for % of Total Sources/',
        'of_total_uses' => 'Evaluation for % of Total Uses/',
        'rev_by_emp' => 'Evaluation for Total Revenue / Employees/',
        'margin' => 'Evaluation for % EBITDA Margins/',
        'lcf_margin' => 'Evaluation for % Levered Free Cash Flow Margins/',
        'levered_free_cashflow' => 'Evaluation for Levered Free Cash Flow Margins/',
        'free_cashflow' => 'Evaluation for Free Cash Flow/',
        'market_value_of_equity' => 'Evaluation for Market/Value Of Equity/',
        'total_enterprise_value' => 'Evaluation for Total Enterprise Value/',
        'total_source_of_cash' => 'Total Sources of Cash/',
        'cash_build_other' => 'Evaluation for Cash Build/Other/',
    };

    $firstArg = match ($type) {
        'yoy_change' => "$metric",
        'net_debt_by_capital' => 'Net Debt',
        'of_total_revenue' => "$metric",
        'of_total_expenses' => "$metric",
        'of_ebitda' => "$metric",
        'of_total_capital' => $metric,
        'of_total_sources' => $metric,
        'of_total_uses' => $metric,
        'rev_by_emp' => 'Total Revenue',
        'margin' => "$metric",
        'lcf_margin' => 'Levered Free Cash Flow',
        'levered_free_cashflow' => 'Free Cashflow',
        'free_cashflow' => 'EBITDA',
        'market_value_of_equity' => 'Total Shares Out. on Filing Date',
        'total_enterprise_value' => 'Market Value of Equity',
        'total_source_of_cash' => 'Levered Free Cash Flow',
        'cash_build_other' => 'Total Sources of Cash',
    };

    $secondArg = match ($type) {
        'yoy_change' => "$metric",
        'net_debt_by_capital' => 'Capital',
        'of_total_revenue' => 'Total Revenue',
        'of_total_expenses' => 'Total Expenses',
        'of_ebitda' => 'EBITDA',
        'of_total_capital' => 'Total Capital',
        'of_total_sources' => 'Total Sources',
        'of_total_uses' => 'Total Uses',
        'rev_by_emp' => 'Employees',
        'margin' => 'Total Revenue',
        'lcf_margin' => "Total Revenue",
        'levered_free_cashflow' => 'Total Changes in Net Working Capital',
        'free_cashflow' => 'Cash Interest',
        'market_value_of_equity' => 'EOD Price',
        'total_enterprise_value' => 'Net Debt',
        'total_source_of_cash' => 'Total Debt Issued',
        'cash_build_other' => 'Cash Acquisitions',
    };

    $formula = match ($type) {
        'yoy_change' => "([$metric]/[$metric]|-1] - 1) * 100",
        'net_debt_by_capital' => '[Net Debt]/[Capital] * 100',
        'of_total_revenue' => "[$metric]/[Total Revenue] * 100",
        'of_total_expenses' => "[$metric]/[Total Expenses] * 100",
        'of_ebitda' => "[$metric]/[EBITDA] * 100",
        'of_total_capital' => "[$metric]/[Total Capital] * 100",
        'of_total_sources' => "[$metric]/[Total Sources] * 100",
        'of_total_uses' => "[$metric]/[Total Uses] * 100",
        'rev_by_emp' => '[Total Revenue]/[Employees]',
        'margin' => '[EBITDA]/[Total Revenue]',
        'lcf_margin' => "[Levered Free Cash Flow]/[Total Revenue] * 100",
        'levered_free_cashflow' => '[Free Cashflow]-[Total Changes in Net Working Capital]',
        'free_cashflow' => '[EBITDA]-([Cash Interest]+[Cash Taxes]+[Capital Expenditures])',
        'market_value_of_equity' => "[$firstArg]*[$secondArg]",
        'total_enterprise_value' => "[$firstArg]+[$secondArg]+[Total Preferred Equity]+[Minority Interest]",
        'total_source_of_cash' => "[$firstArg]+[$secondArg]+[Total Preferred Equity]+[Issuance of Common Stock]",
        'cash_build_other' => "[$firstArg]-[$secondArg]-[Total Debt Repaid]-[Repurchase of Preferred Stock]-[Repurchase of Common Stock]-[Total Dividends Paid]",
    };

    $resolved = match ($type) {
        'yoy_change' => "($arguments[0]/$arguments[1] - 1) * 100",
        'net_debt_by_capital' => "$arguments[0]/$arguments[1] * 100",
        'of_total_revenue' => "$arguments[0]/$arguments[1] * 100",
        'of_total_expenses' => "$arguments[0]/$arguments[1] * 100",
        'of_ebitda' => "$arguments[0]/$arguments[1] * 100",
        'of_total_capital' => "$arguments[0]/$arguments[1] * 100",
        'of_total_sources' => "$arguments[0]/$arguments[1] * 100",
        'of_total_uses' => "$arguments[0]/$arguments[1] * 100",
        'rev_by_emp' => "$arguments[0]/$arguments[1] * 100",
        'margin' => "$arguments[0]/$arguments[1] * 100",
        'lcf_margin' => "$arguments[0]/$arguments[1] * 100",
        'levered_free_cashflow' => "$arguments[0] - $arguments[1]",
        'free_cashflow' => 'Evaluation for Free Cash Flow',
        'market_value_of_equity' => "$arguments[0]*$arguments[1]",
        'total_enterprise_value' => "$arguments[0]+$arguments[1]+$arguments[2]+$arguments[3]",
        'total_source_of_cash' => "$arguments[0]+$arguments[1]+$arguments[2]+$arguments[3]",
        'cash_build_other' => "$arguments[0]-$arguments[1]-$arguments[2]-$arguments[3]-$arguments[4]-$arguments[5]",
    };

    $result = [
        'message' => $title . $date,
        'body' => [
            'value_final' => $result,
            'value_final_raw' => $result,
            'value_tikr' => null,
            'value_from_mapping' => '-',
            'measure' => '%',
            'value_from_mapping_raw' => '-',
            'mapping_info' => [
                'effectively_mapped_to' => null,
                'high_grade_mapping' => [''],
                'automated_mapping' => null
            ],
            'formula_evaluation' => [
                [
                    'formula' => $formula,
                    'resolved' => $resolved,
                    'equals' => $result,
                    'result' => 'Ok',
                    'arguments' => [
                        "$firstArg" => [
                            'value' => $arguments[0],
                            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
                            'data_type' => 'xbrli:monetaryItemType',
                            'hint' => ' ',
                            'sub_arguments' => null
                        ],
                        $secondArg === $firstArg ? "$secondArg| - 1" : $secondArg => [
                            'value' => $arguments[1],
                            'hash' => 'a9bb60d7779632da95208e0fa41b25201dd06b91',
                            'data_type' => 'xbrli:monetaryItemType',
                            'hint' => ' ',
                            'sub_arguments' => null
                        ]
                    ]
                ]
            ]
        ]
    ];

    if ($type === 'free_cashflow') {
        $result['body']['formula_evaluation'][0]['arguments']['Cash Taxes'] = [
            'value' => $arguments[2],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];

        $result['body']['formula_evaluation'][0]['arguments']['Capital Expenditures'] = [
            'value' => $arguments[3],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];
    }

    if ($type === 'total_enterprise_value') {
        $result['body']['formula_evaluation'][0]['arguments']['Total Preferred Equity'] = [
            'value' => $arguments[2],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];

        $result['body']['formula_evaluation'][0]['arguments']['Minority Interest'] = [
            'value' => $arguments[3],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];
    }

    if ($type === 'total_enterprise_value') {
        $result['body']['formula_evaluation'][0]['arguments']['Total Preferred Equity'] = [
            'value' => $arguments[2],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];

        $result['body']['formula_evaluation'][0]['arguments']['Minority Interest'] = [
            'value' => $arguments[3],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];
    }

    if ($type === 'total_source_of_cash') {
        $result['body']['formula_evaluation'][0]['arguments']['Total Preferred Equity'] = [
            'value' => $arguments[2],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];

        $result['body']['formula_evaluation'][0]['arguments']['Issuance of Common Stock'] = [
            'value' => $arguments[3],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];
    }

    if ($type === 'cash_build_other') {
        $result['body']['formula_evaluation'][0]['arguments']['Total Debt Repaid'] = [
            'value' => $arguments[2],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];

        $result['body']['formula_evaluation'][0]['arguments']['Repurchase of Preferred Stock'] = [
            'value' => $arguments[3],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];

        $result['body']['formula_evaluation'][0]['arguments']['Repurchase of Common Stock'] = [
            'value' => $arguments[4],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];

        $result['body']['formula_evaluation'][0]['arguments']['Total Dividends Paid'] = [
            'value' => $arguments[5],
            'hash' => '71a9a77670a4390b859dc45634c6470b6edf17da',
            'data_type' => 'xbrli:monetaryItemType',
            'hint' => ' ',
            'sub_arguments' => null
        ];
    }

    return $result;
}

function extractTickerFromUrl($path)
{
    $ticker = '';
    $segments = explode('/', trim($path, '/'));

    if (isset($segments[0]) && $segments[0] === 'company' && isset($segments[1])) {
        return $segments[1];
    }

    if (str_contains($path, '?')) {
        $parts = explode('?', $path);
        $queryString = $parts[1];
        $queryItems = [];

        parse_str($queryString, $queryItems);

        if (isset($queryItems['ticker'])) {
            return $queryItems['ticker'];
        }
    }

    return $ticker;
}

function validateAndSetDefaults($settings)
{
    $availableViews = ['As reported', 'Adjusted', 'Standardized', 'Per Share', 'Common size'];
    $availablePeriods = ['Fiscal Annual', 'Fiscal Quarterly', 'Fiscal Semi-Annual', 'YTD', 'LTM', 'Calendar Annual'];
    $availableUnits = ['Billions', 'Millions', 'Thousands', 'As Stated'];
    $availableOrders = ['Latest on the Right', 'Latest on the Left'];
    $availableFreezePanes = ['Top Row', 'First Column', 'Top Row & First Column'];
    $availablePublicView = ['yes', 'no'];

    $settings['view'] = in_array($settings['view'] ?? null, $availableViews) ? $settings['view'] : 'As reported';
    $settings['period'] = in_array($settings['period'] ?? null, $availablePeriods) ? $settings['period'] : 'Fiscal Annual';

    if (
        !is_array($settings['defaultYearRange']) || count($settings['defaultYearRange']) != 2 ||
        !is_int($settings['defaultYearRange'][0]) || !is_int($settings['defaultYearRange'][1])
    ) {
        $settings['defaultYearRange'] = [2005, 2023];
    }

    $settings['unit'] = in_array($settings['unit'] ?? null, $availableUnits) ? $settings['unit'] : 'Millions';
    $settings['order'] = in_array($settings['order'] ?? null, $availableOrders) ? $settings['order'] : 'Latest on the Right';
    $settings['freezePane'] = in_array($settings['freezePane'] ?? null, $availableFreezePanes) ? $settings['freezePane'] : 'Top Row & First Column';
    $settings['publicView'] = in_array($settings['publicView'] ?? null, $availablePublicView) ? $settings['publicView'] : 'no';

    $settings['decimalPlaces'] = (is_int($settings['decimalPlaces'] ?? null) && $settings['decimalPlaces'] >= 0) ? $settings['decimalPlaces'] : 1;
    $settings['perShareDecimalPlaces'] = (is_int($settings['perShareDecimalPlaces'] ?? null) && $settings['perShareDecimalPlaces'] >= 0) ? $settings['perShareDecimalPlaces'] : 2;
    $settings['percentageDecimalPlaces'] = (is_int($settings['percentageDecimalPlaces'] ?? null) && $settings['percentageDecimalPlaces'] >= 0) ? $settings['percentageDecimalPlaces'] : 2;

    return $settings;
}

function formatAdviserString($str) {
    if ($str == 'None') return '';
    return $str;
}

function formatAdviserBoolean($str) {
    if ($str == 'Y') return True;
    return False;
}

function formatAdviserStates($str) {
    return array_map(function($item) {
        return substr($item, 0, 2);
    }, explode(" ", $str));
}

function formatAdviserInteger($str) {
    if ($str == 'None') return 0;
    return (int) $str;
}
function debugQuery($query)
{
    $sql = $query->toSql();
    $bindings = $query->getBindings();
    $fullSql = vsprintf(str_replace('?', '%s', $sql), collect($bindings)->map(function ($binding) {
        return is_numeric($binding) ? $binding : "'$binding'";
    })->toArray());

    return $fullSql;
}

function getRouteNameFromUrl($url) {
    $routes = Route::getRoutes();

    foreach ($routes as $route) {
        if ($route->matches(request()->create($url))) {
            return $route->getName();
        }
    }

    return null;
}