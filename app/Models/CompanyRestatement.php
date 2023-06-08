<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRestatement extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id';

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
    protected $table = 'restated_log';

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
        'id',
        'cik',
        'qname',
        'period',
        'period_report_restated',
        'value_restated',
        'value_correction',
        'period_report_non_restated',
        'value_non_restated',
        'transition_type'
    ];

}
