<?php

namespace App\Models;

use Illuminate\Support\Str;
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
        'is_route',
        'is_moddable',
    ];

    protected $casts = [
        'is_route' => 'boolean',
        'is_moddable' => 'boolean',
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

    public static function getPrimaryLinks($navItems)
    {
        return $navItems->where(function ($nav) {
            return !Str::startsWith(
                $nav->route_name,
                ['company.', 'lse.', 'tsx.', 'fund.', 'mutual-fund.', 'etf.', 'shanghai.', 'japan.', 'hkex.', 'otc.', 'frankfurt.', 'euronext.', 'shenzhen.', 'economics-release', 'create.']
            );
        })
        ->values();
    }
}
