<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etf extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cik';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'etfs';

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cik',
        'registrant_name',
        'etf_symbol',
        'series_id',
        'class_id',
        'class_name',
    ];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'pgsql'; 

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
