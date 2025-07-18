<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hkex extends Model
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
    protected $table = 'hkexs';

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'symbol',
        'short_name'
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
