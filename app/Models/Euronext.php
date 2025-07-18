<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Euronext extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'symbol';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'euronexts';

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'symbol',
        'registrant_name',
        'market',
        'market_full_name',
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
