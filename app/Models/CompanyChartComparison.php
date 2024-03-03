<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyChartComparison extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'companies',
        'metrics',
        'user_id',
    ];

    protected $casts = [
        'companies' => 'array',
        'metrics' => 'array',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
