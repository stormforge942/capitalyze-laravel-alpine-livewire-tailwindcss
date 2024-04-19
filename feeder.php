<?php

/**
 * Usage php feeder.php --drop={true|false} --tables={table1,table2,table3}
 * 
 *  @param bool drop - drop the database before creating it
 *  @param string tables - comma separated list of tables to replicate
 */

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$xbrl = new PDO('pgsql:host=xbrl.cglbwnpyaomf.us-east-1.rds.amazonaws.com;port=5432;dbname=xbrl', 'postgres', 'frQ54%4H2CIu');

if (!$xbrl) {
    die('Could not connect to the database');
}

$args = getArgs($argv);
$tables = [
    'as_reported_sec_annual_restated_api',
    'as_reported_sec_annual_restated_full_api',
    'as_reported_sec_quarter_restated_api',
    'as_reported_sec_quarter_restated_full_api',
    'as_reported_sec_segmentation_api',
    'as_reported_sec_text_block_content',
    'company_identifiers',
    'company_links',
    'company_presentation',
    'company_profile',
    'company_profile_intl',
    'data_observations',
    'data_series',
    'delistings',
    'earnings_calendar',
    'economic_releases',
    'employee_count',
    'eod_prices',
    'etf_holdings',
    'etf_holdings_feed',
    'euronext_statements',
    'executive_compensation',
    'fail_to_deliver',
    'filings',
    'filings_summary',
    'frankfurt_statements',
    'fund_returns',
    'hkex_feed',
    'hkex_statements',
    'hkex_urls',
    'house_trading',
    'industry_summary',
    'info_facts_data',
    'info_presentations',
    'info_tikr_presentations',
    'insider_transactions',
    'japan_feed',
    'japan_statements',
    'japan_urls',
    'lse_statements',
    'mutual_fund_holdings',
    'mutual_fund_holdings_feed',
    'mutual_fund_holdings_summary',
    'mutual_fund_industry_summary',
    'new_earnings',
    'otc_feed',
    'otc_statements',
    'otc_urls',
    'press_releases',
    'restated_log',
    'rss_feed',
    'shanghai_feed',
    'shanghai_statements',
    'shenzhen_feed',
    'shenzhen_statements',
    'splits',
    'symbol_summary',
    'tikr_text_block_content',
    'tsx_statements',
    'info_idx_tb',
];

$replica = makeDatabase($args['drop']);

$selectedTables = selectedTables($tables, $args);

replicateSchema($xbrl, $replica, $selectedTables, true);

$symbols = [
    'AAPL',
    'MSFT',
    'VMI'
];

$ciks = [
    '0001948780',
    '0001978885',
    '0001911472'
];

fillData($xbrl, $replica, $selectedTables, $symbols, $ciks);

function getArgs($argv)
{
    $args = [];
    foreach ($argv as $idx => $arg) {
        if ($idx === 0) continue;

        if (strpos($arg, '--') === 0) {
            $arg = substr($arg, 2);
            $arg = explode('=', $arg);
            $args[$arg[0]] = $arg[1];
        }
    }

    $args['drop'] = ($args['drop'] ?? '') === 'true';
    $args['tables'] = ($args['tables'] ?? '') ?? null;

    return $args;
}

function makeDatabase($drop)
{
    $host = '127.0.0.1'; // only works with localhost
    $port = $_ENV['DB_PORT_XBRL'];
    $db = $_ENV['DB_DATABASE_XBRL'];
    $user = $_ENV['DB_USERNAME_XBRL'];
    $password = $_ENV['DB_PASSWORD_XBRL'];

    if ($drop) {
        $replica = new PDO("pgsql:host=$host;port=$port;dbname=postgres", $user, $password);
        $replica->exec("DROP DATABASE IF EXISTS $db");
        $replica->exec("CREATE DATABASE $db");
    }

    $replica = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $password);

    return $replica;
}

function selectedTables($tables, $args)
{
    if (!$args['tables']) {
        return $tables;
    }

    $selected = explode(',', $args['tables']);

    return array_values(array_filter($tables, fn ($table) => in_array($table, $selected)));
}

function replicateSchema($xbrl, $replica, $tables, $drop = false)
{
    foreach ($tables as $table) {
        if ($drop) {
            $replica->exec("DROP TABLE IF EXISTS $table");
        }

        $stmt = $xbrl->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name='$table'");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $columns = array_map(function ($column) {
            return $column['column_name'] . ' ' . $column['data_type'];
        }, $columns);
        $columns = implode(', ', $columns);

        $replica->exec("CREATE TABLE $table ($columns)");
    }
}

function fillData($xbrl, $replica, $tables, $symbols, $ciks)
{
    $stringSymbols = "'" . implode("', '", $symbols) . "'";
    $stringCiks = "'" . implode("', '", $ciks) . "'";

    foreach ($tables as $table) {
        print("Filling $table\n");
        $stmt = null;
        if (in_array($table, ['company_profile', 'eod_prices', 'as_reported_sec_segmentation_api', 'info_tikr_presentations', 'company_presentation', 'info_presentations', 'employee_count', 'company_links', 'insider_transactions'])) {
            $_stringSymbols = $table === 'eod_prices' ? strtolower($stringSymbols) : $stringSymbols;

            $symbolColumn = in_array($table, ['as_reported_sec_segmentation_api', 'info_tikr_presentations', 'info_presentations']) ? 'ticker' : 'symbol';

            $stmt = $xbrl->query("SELECT * FROM $table WHERE $symbolColumn IN ($_stringSymbols)");
        } else if ($table === 'filings') {
            $stmt = $xbrl->query("SELECT * FROM $table where cik in ($stringCiks) order by report_calendar_or_quarter desc limit 1000");
        } else if ($table === 'mutual_fund_holdings') {
            $stmt = $xbrl->query("SELECT * FROM $table where symbol in ($stringSymbols) order by period_of_report desc limit 1000");
        } else if ($table === 'filings_summary' || $table === 'industry_summary') {
            $ciks = $replica->query("SELECT distinct cik FROM filings")->fetchAll(PDO::FETCH_COLUMN);
            $ciks = array_map(fn ($cik) => "'$cik'", $ciks);
            $ciks = implode(',', $ciks);

            if ($table === 'filings_summary' && $ciks != '') {
                $stmt = $xbrl->query("SELECT * FROM $table WHERE is_latest=true or date='2023-12-31' and cik in ($ciks)");
                print("Filling $table with $ciks\n");
            } else if ($ciks != '') {
                $stmt = $xbrl->query("SELECT * FROM $table WHERE cik in ($ciks) order by date desc limit 5000");
            }
        } else if ($table === 'mutual_fund_holdings_summary') {
            $ciks = $replica->query("SELECT distinct cik FROM mutual_fund_holdings")->fetchAll(PDO::FETCH_COLUMN);
            $ciks = array_map(fn ($cik) => "'$cik'", $ciks);
            $ciks = implode(',', $ciks);

            $stmt = $xbrl->query("SELECT * FROM $table WHERE is_latest=true or date='2023-12-31' and cik in ($ciks)");
        } else if ($table === 'earnings_calendar') {
            $start = now()->subDay()->toDateString();
            $end = now()->addWeek()->endOfWeek()->toDateString();

            $stmt = $xbrl->query("SELECT * FROM $table where date between '$start' and '$end'");
        } else if (in_array($table, ['info_idx_tb', 'tikr_text_block_content', 'as_reported_sec_text_block_content'])) {
            $stmt = $xbrl->query("SELECT * FROM $table where ticker in ($stringSymbols) limit 1000");
        }

        if (!$stmt) continue;

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($data) === 0) continue;
        $columns = array_keys($data[0]);
        $columns = implode(', ', $columns);

        $values = array_map(function ($row) {
            $row = array_map(function ($value) {
                if (is_null($value)) {
                    return 'NULL';
                }

                if (is_bool($value)) {
                    return $value ? 'true' : 'false';
                }

                if (!is_string($value)) {
                    return $value;
                }

                // escape single quotes
                $value = str_replace("'", "''", $value);

                return "'$value'";
            }, $row);
            return '(' . implode(', ', $row) . ')';
        }, $data);
        $values = implode(', ', $values);

        $replica->exec("INSERT INTO $table ($columns) VALUES $values");
    }
}
