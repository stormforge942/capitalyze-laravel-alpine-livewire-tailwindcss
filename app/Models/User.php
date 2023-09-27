<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_approved',
        'is_admin',
        'group_id',
        'likedin_link',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function isAdmin()
    {
        return $this->is_admin === true;
    }

    public function hasNavbar($routeName): bool
    {
        return
            $this->isAdmin() ||
            Navbar::where('route_name', $routeName)
            ->where('is_moddable', true)
            ->whereHas(
                'navbarGroupShows',
                fn ($query) => $query
                    ->where('navbar_group_shows.group_id', $this->group_id)
                    ->where('navbar_group_shows.show', true)
            )
            ->exists();
    }

    public function getInitialsAttribute()
    {
        $nameParts = explode(' ', $this->name);
        $initials = '';

        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        return $initials;
    }
}
