<?php

namespace App\Http\Livewire\CompanyAnalysis;

trait HasFilters
{
    public string $period = 'annual';
    public string $unit = 'Thousands';
    public int $decimalPlaces = 2;
    public string $dateOrder = 'ltr';
    public string $freezePane = '';

    public $dates = [];
    public $selectedDates = [];
    public array $selectedDateRange = [];

    protected $chartColors = [];

    public function bootHasFilters()
    {
        $this->chartColors = [
            "#464E49",
            "#9A46CD",
            "#52D3A2",
            "#3561E7",
            "#E38E48",
            "#39a80f",
            "#cb6c2d",
            "#8a2aa7",
            "#c47f2b",
            "#1634a3",
            "#80914c",
            "#4b0e84",
            "#070cc6",
            "#d16882",
            "#cb14d2",
        ];
    }

    public function isReverseOrder(): bool
    {
        return $this->dateOrder == 'ltl';
    }

    private function formatValue($value): string
    {
        $valueDivisor = match ($this->unit) {
            'Thousands' => 1000,
            'Millions' => 1000000,
            'Billions' => 1000000000,
            default => 1,
        };

        $value = $value / $valueDivisor;

        $formatted = number_format($value, $this->decimalPlaces);

        // remove trailing zeros
        $formatted = preg_replace('/\.?0+$/', '', $formatted);

        return $formatted;
    }

    private function formatPercentageValue($value): string
    {
        return round($value, $this->decimalPlaces) . '%';
    }

    private function selectDates($dates)
    {
        usort($dates, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });

        $this->dates = $dates;

        if (!count($dates)) {
            return;
        }

        $startYear = ((int) explode('-', end($dates))[0]) - 5;

        $this->selectedDates = array_values(
            array_filter($dates, fn ($date) => intval(explode('-', $date)[0]) >= $startYear)
        );

        if (count($this->selectedDates)) {
            $this->selectedDateRange = [
                intval(explode('-', $this->selectedDates[0])[0]),
                intval(explode('-', $this->selectedDates[count($this->selectedDates) - 1])[0]),
            ];

            $this->selectedDateRange[0] = min(...$this->selectedDateRange);
            $this->selectedDateRange[1] = max(...$this->selectedDateRange);
        }
    }

    private function updateSelectedDates()
    {
        $this->selectedDates = array_values(
            array_filter(
                $this->dates,
                fn ($date) => intval(explode('-', $date)[0]) >= $this->selectedDateRange[0] &&
                    intval(explode('-', $date)[0]) <= $this->selectedDateRange[1]
            )
        );
    }

    private function makeChartKey(): string
    {
        return $this->period . '-' . json_encode($this->selectedDateRange);
    }
}
