<?php

namespace App\Models;

use App\Enums\Plan;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plan',
        'owner_id',
        'email',
        'industry',
        'country',
        'employees',
        'cik',
        'website',
        'linkedin_link',
        'twitter_link',
        'facebook_link',
    ];

    protected $appends = [
        'company_size',
    ];

    protected $casts = [
        'plan' => Plan::class,
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(PendingInvitation::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role_id')
            ->using(TeamMember::class);
    }

    public function allMembers(): Collection
    {
        return $this->members()->get()->merge([$this->owner]);
    }

    public function isMember(User|int $user): bool
    {
        if (! is_int($user)) {
            $user = $user->id;
        }

        return $this->owner_id === $user || TeamMember::where('team_id', $this->id)->where('user_id', $user)->exists();
    }

    public function companySize(): Attribute
    {
        return Attribute::make(
            get: function () {
                $employees = $this->employees;

                if ($employees < 50) {
                    return '0-50';
                }
                if ($employees < 100) {
                    return '50-100';
                }
                if ($employees < 500) {
                    return '100-500';
                }

                return '500+';
            }
        );
    }
}
