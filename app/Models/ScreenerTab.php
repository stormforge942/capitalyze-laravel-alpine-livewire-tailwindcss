<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function locations(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = json_decode($value, true);
                if (!isset($data)) {
                    return [
                        "data" => [],
                        "exclude" => false
                    ];
                }

                return $data;
            },
            set: function ($value) {
                return json_encode($value);
            }
        );
    }

    protected function stockExchanges(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = json_decode($value, true);
                if (!isset($data)) {
                    return [
                        "data" => [],
                        "exclude" => false
                    ];
                }

                return $data;
            },
            set: function ($value) {
                return json_encode($value);
            }
        );
    }

    protected function industries(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = json_decode($value, true);
                if (!isset($value)) {
                    return [
                        "data" => [],
                        "exclude" => false
                    ];
                }

                return $data;
            },
            set: function ($value) {
                return json_encode($value);
            }
        );
    }

    protected function sectors(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = json_decode($value, true);
                if (!isset($data)) {
                    return [
                        "data" => [],
                        "exclude" => false
                    ];
                }

                return $data;
            },
            set: function ($value) {
                return json_encode($value);
            }
        );
    }

    protected function currencies(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = json_decode($value, true);
                if (!isset($data)) {
                    return [
                        "data" => [],
                        "exclude" => false
                    ];
                }

                return $data;
            },
            set: function ($value) {
                return json_encode($value);
            }
        );
    }

    protected function selectedFinancialCriteria(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = json_decode($value, true);

                $criterion['id'] = uniqid();
                $criterion['value'] = [];

                $criteria[] = $criterion;

                if (!isset($data)) {
                    return $criteria;
                }

                return $data;
            },
            set: function ($value) {
                return json_encode($value);
            }
        );
    }

    protected function decimal(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $data = json_decode($value, true);
                if (!isset($data)) {
                    return [
                        'decimalPlaces' => 0,
                        'percentageDecimalPlaces' => 0,
                        'perShareDecimalPlaces' => 0
                    ];
                }

                return $data;
            },
            set: function ($value) {
                return json_encode($value);
            }
        );
    }
}
