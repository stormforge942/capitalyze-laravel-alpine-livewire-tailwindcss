<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
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
    protected $table = 'navbars';

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'route_name',
        'is_moddable'
    ];

    public function navbarGroupShows()
    {
        return $this->hasMany(NavbarGroupShows::class);
    }

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
}
