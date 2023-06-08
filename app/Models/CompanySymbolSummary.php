<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySymbolSummary extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $primaryKey = 'symbol'; // use one part of the composite key as primary
    protected $keyType = 'string'; // if your key is string, not necessary for integer keys


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'symbol_summary'; 

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'pgsql-xbrl';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'symbol',
        'cik',
        'date',
        'investors_holding',
        'last_investors_holding',
        'investors_holding_change',
        'thirteenf_shares',
        'last_thirteenf_shares',
        'thirteenf_shares_change',
        'total_invested',
        'last_total_invested',
        'total_invested_change',
        'ownership_percent',
        'last_ownership_percent',
        'ownership_percent_change',
        'new_positions',
        'last_new_positions',
        'new_positions_change',
        'increased_positions',
        'last_increased_positions',
        'increased_positions_change',
        'closed_positions',
        'last_closed_positions',
        'closed_positions_change',
        'reduced_positions',
        'last_reduced_positions',
        'reduced_positions_change',
        'total_calls',
        'last_total_calls',
        'total_calls_change',
        'total_puts',
        'last_total_puts',
        'total_puts_change',
        'put_call_ratio',
        'last_put_call_ratio',
        'put_call_ratio_change'
    ];

    public function getKey()
    {
        return [
            'symbol' => $this->attributes['symbol'],
            'date' => $this->attributes['date']
        ];
    }
}
