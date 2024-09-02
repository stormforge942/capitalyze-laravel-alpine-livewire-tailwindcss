<?php

namespace App\Models;

use App\Traits\HasNavbar;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasNavbar;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'job',
        'dob',
        'country',
        'is_approved',
        'is_admin',
        'group_id',
        'linkedin_link',
        'facebook_link',
        'twitter_link',
        'settings',
        'last_activity_at',
        'is_password_set',
        'current_team_id',
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
        'two_factor_email',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_approved' => 'boolean',
        'is_password_set' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'initials',
    ];

    public function initials(): Attribute
    {
        return Attribute::make(
            get: function () {
                $nameParts = explode(' ', $this->name);
                $initials = '';

                foreach ($nameParts as $part) {
                    $initials .= strtoupper(substr($part, 0, 1));
                }

                return substr($initials, 0, 2);
            }
        );
    }

    public function firstName(): Attribute
    {
        return Attribute::make(get: fn() => explode(' ', $this->name)[0]);
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'current_team_id');
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;

        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function isTwoFactorEnabled()
    {
        return $this->two_factor_email != null;
    }

    public function updateProfilePhoto(UploadedFile $photo)
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => Storage::disk($this->profilePhotoDisk())->put('profile-photos', $photo),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    public function getSetting(string $key, mixed $default = null)
    {
        return ($this->settings ?? [])[$key] ?? $default;
    }

    public function updateSetting(string $key, mixed $value)
    {
        $settings = $this->settings ?? [];

        $settings[$key] = $value;

        $this->update(['settings' => $settings]);
    }
}
