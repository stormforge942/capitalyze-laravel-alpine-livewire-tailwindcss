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
        'filters',
        'metric_attributes',
        'panel',
        'user_id',
        'metrics_color',
    ];

    protected $casts = [
        'companies' => 'array',
        'metrics' => 'array',
        'filters' => 'array',
        'metric_attributes' => 'array',
        'metrics_color' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
