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
        'table_order',
        'settings',
        'user_id',
    ];

    protected $casts = [
        'companies' => 'array',
        'metrics' => 'array',
        'summaries' => 'array',
        'notes' => 'array',
        'table_order' => 'array',
        'settings' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parsedSettings(): array
    {
        $settings = $this->settings ?? [];

        $settings['decimalPlaces'] = data_get($settings, 'decimalPlaces', 2);
        $settings['unit'] = data_get($settings, 'unit', 'Millions');

        return $settings;
    }
}
