<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInsider extends Model
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
            $model->{$model->getKeyName()} = $model->symbol . '-' . $model->form_type . '-' . $model->derivative_or_nonderivative . '-' . $model->amount_of_securities . '-' . $model->securities_owned_following_transaction . '-' . $model->acceptance_time;

        });
    }

    /**
     * The primary key for the model.
     *  symbol,form_type,derivative_or_nonderivative,amount_of_securities,securities_owned_following_transaction,acceptance_time
     * @var array
     */
    protected $primaryKey = ['symbol', 'form_type', 'derivative_or_nonderivative', 'amount_of_securities', 'securities_owned_following_transaction', 'acceptance_time'];

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
    protected $table = 'insider_transactions';

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
        'registrant_name',
        'form_type',
        'reporting_person',
        'reporting_cik',
        'relationship_of_reporting_person',
        'individual_or_joint_filing',
        'derivative_or_nonderivative',
        'title_of_security',
        'transaction_date',
        'transaction_code',
        'amount_of_securities',
        'price_per_security',
        'acquired_or_disposed',
        'title_of_underlying_security',
        'amount_of_underlying_securities',
        'securities_owned_following_transaction',
        'ownership_form',
        'nature_of_ownership',
        'acceptance_time',
        'url'
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
