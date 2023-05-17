<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyFilings extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filings'; // replace with your actual table name

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'pgsql-xbrl'; // replace with your actual connection name

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; // set to true if your table has timestamps

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'change_in_ownership',
        'change_in_ownership_percentage',
        'change_in_performance',
        'change_in_shares',
        'change_in_shares_percentage',
        'change_in_value',
        'change_in_value_percentage',
        'change_in_weight',
        'change_in_weight_percentage',
        'cik',
        'cusip',
        'first_added',
        'holding_period',
        'industry_title',
        'investment_discretion',
        'investor_name',
        'is_counted',
        'is_new',
        'is_sold_out',
        'last_ownership',
        'last_performance',
        'last_price_paid',
        'last_shares',
        'last_value',
        'last_weight',
        'name_of_issuer',
        'ownership',
        'performance',
        'performance_percentage',
        'price_paid',
        'put_call',
        'report_calendar_or_quarter',
        'signature_date',
        'ssh_prnamt',
        'ssh_prnamt_type',
        'symbol',
        'title_of_class',
        'value',
        'weight'
    ];
}
