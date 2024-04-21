<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyTableComparison extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'companies',
        'metrics',
        'summaries',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'companies' => 'array',
        'metrics' => 'array',
        'summaries' => 'array',
        'notes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
