<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MutualFundsReturn extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cik';

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
    protected $table = 'public.fund_returns';

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
        'registrant_name',
        'symbol',
        'series_id',
        'class_id',
        'acceptance_time'
    ];

}
