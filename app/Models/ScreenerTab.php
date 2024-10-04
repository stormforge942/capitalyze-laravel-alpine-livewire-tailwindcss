<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'view',
    ];

    protected $casts = [
        'universal_criteria' => 'array',
        'financial_criteria' => 'array',
        'summaries' => 'array',
        'views' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addView(array $view)
    {
        $views = $this->views ?? [];

        $view = [
            'id' => Str::uuid()->toString(),
            'name' => $view['name'],
            'config' => $view['config'] ?? [],
        ];

        if ($view['id'] === 'default' || collect($this->views)->firstWhere('id', $view['id'])) {
            throw new \Exception('Invalid view ID');
        }

        $this->update([
            'views' => [
                ...$views,
                $view,
            ],
        ]);

        return $view;
    }

    public function updateViewConfig(string $id, array $config)
    {
        $views = $this->views ?? [];

        foreach ($views as $idx => $view) {
            if ($view['id'] === $id) {
                $views[$idx]['config'] = $config;
            }
        }

        $this->update([
            'views' => $views,
        ]);
    }
}
