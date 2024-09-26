<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScreenerTab extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'universal_criteria',
        'financial_criteria',
        'summaries',
        'views',
        'user_id',
    ];

    protected $casts = [
        'universal_criteria' => 'array',
        'financial_criteria' => 'array',
        'summaries' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
