<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavbarGroupShows extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'navbar_group_shows';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'navbar_id',
        'group_id',
        'show'
    ];

    protected $casts = [
        'show' => 'boolean'
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
    public $incrementing = true;

    public function navbar(): BelongsTo
    {
        return $this->belongsTo(Navbar::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Groups::class);
    }
}
