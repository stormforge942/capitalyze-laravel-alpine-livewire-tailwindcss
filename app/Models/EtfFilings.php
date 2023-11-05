<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtfFilings extends Model
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
            $model->{$model->getKeyName()} = $model->cik . '-' . $model->acceptance_time;
        });
    }

    /**
     * The primary key for the model.
     *
     * @var array
     */
    protected $primaryKey = ['cik', 'acceptance_time'];

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
    protected $table = 'public.etf_holdings_feed';

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
        'cik',
        'acceptance_time',
        'period_of_report'
    ];
}
