<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class PendingInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'role_id',
        'team_id',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function accept(User $user, bool $transaction = true): void
    {
        $fn = function () use ($user) {
            TeamMember::query()
                ->updateOrCreate([
                    'user_id' => $user->id,
                    'team_id' => $this->team_id,
                ], [
                    'role_id' => $this->role_id,
                ]);

            $user->update(['current_team_id' => $this->team_id]);

            self::query()
                ->where([
                    'email' => $this->email,
                    'team_id' => $this->team_id,
                ])
                ->delete();
        };

        if ($transaction) {
            DB::transaction($fn);

            return;
        }

        $fn();
    }
}
