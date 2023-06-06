<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyFilings extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->cik . '-' . $model->cusip . '-' . $model->put_call . '-' . $model->report_calendar_or_quarter;
        });
    }

    /**
     * The primary key for the model.
     *
     * @var array
     */
    protected $primaryKey = ['cik', 'cusip', 'put_call', 'report_calendar_or_quarter'];

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

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param  mixed  $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
