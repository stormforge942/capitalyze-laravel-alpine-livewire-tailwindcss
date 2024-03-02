<?php

namespace App\Http\Livewire\CompanyAnalysis;

use Carbon\Carbon;

trait HasFilters
{
    public string $period = 'annual';
    public string $unit = 'Thousands';
    public int $decimalPlaces = 2;
    public string $dateOrder = 'ltr';
    public string $freezePane = 'Top Row & First Column';

    public $dates = [];
    public $selectedDates = [];
    public array $selectedDateRange = [];

    protected $chartColors = [];

    public function bootHasFilters()
    {
        $this->chartColors = config('capitalyze.chartColors');
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

        $dateRange = [
            (int) explode('-', $dates[0])[0],
            (int) explode('-', end($dates))[0],
        ];

        $startYear = ((int) explode('-', end($dates))[0]) - 5;

        // update selected date range only if its needed
        if (count($this->selectedDateRange) === 2) {
            $this->selectedDateRange[0] = $this->selectedDateRange[0] >= $dateRange[0]
                ? $this->selectedDateRange[0]
                : $dateRange[0];
            $this->selectedDateRange[1] = $this->selectedDateRange[1] <= $dateRange[1]
                ? $this->selectedDateRange[1]
                : $dateRange[1];
        } else {
            $this->selectedDateRange[0] = $startYear;
            $this->selectedDateRange[1] = $dateRange[1];
        }

        $this->updateSelectedDates();
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

    private function rangeSliderKey(): string
    {
        return json_encode([
            $this->dates[0],
            $this->dates[count($this->dates) - 1],
            $this->selectedDateRange[0] ?? null,
            $this->selectedDateRange[1] ?? null,
        ]);
    }

    private function formatDateForChart(string $date)
    {
        if ($this->period === 'annual') {
            return explode("-", $date)[0];
        }

        return Carbon::parse($date)->format('M Y');
    }
}
