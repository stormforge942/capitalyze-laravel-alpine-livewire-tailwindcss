<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataSettings extends Component
{
    use AsTab;

    public $data_settings_columns = [
        'viewTypes' => [
            'title' => 'View',
            'description' => 'View data in different formats',
            'options' => [
                'As reported' => 'As Reported',
                'Adjusted' => 'Adjusted',
                'Standardized' => 'Standardized',
                'Per Share' => 'Per Share',
                'Common size' => 'Common size',
            ],
        ],
        'periodTypes' => [
            'title' => 'Period Type',
            'description' => 'Choose preferred period type',
            'options' => [
                'Fiscal Annual' => 'Fiscal Annual',
                'Fiscal Quarterly' => 'Fiscal Quartery',
                'Fiscal Semi-Annual' => 'Fiscal Semi-Annual',
                'YTD' => 'YTD',
                'LTM' => 'LTM',
                'Calendar Annual' => 'Calendar Annual',
            ],
        ],
        'defaultYearRange' => [
            'title' => 'Default Year Range',
            'description' => 'Choose preferred year range',
            'type' => 'year-range',
        ],
        'unitTypes' => [
            'title' => 'Unit Type',
            'description' => 'Enterprise',
            'options' => [
                'Billions' => 'Billions',
                'Millions' => 'Millions',
                'Thousands' => 'Thousands',
                'As Stated' => 'As Stated',
            ],
        ],
        'decimal' => [
            'title' => 'Decimal',
            'description' => 'Enterprise',
            'type' => 'decimal',
        ],
        'orderTypes' => [
            'title' => 'Order',
            'description' => 'Enterprise',
            'options' => [
                'Latest On The Right' => 'Latest On The Right',
                'Latest On The Left' => 'Latest On The Left',
            ],
        ],
        'freezePaneTypes' => [
            'title' => 'Freeze Panes',
            'description' => 'Enerprise',
            'options' => [
                'Top Row' => 'Top Row',
                'First Column' => 'First Column',
                'Top Row & First Column' => 'Top Row & First Column',
            ],
        ],
    ];

    public $settings;

    public function mount()
    {
        $settings = Auth::user()->settings;

        if (gettype($settings) == 'string') {
            $settings = json_decode($settings);
        }
        if (gettype($settings) == 'object') {
            $settings = (array) $settings;
        }

        if ($settings == null || empty($settings)) {
            $settings = [
                'view' => 'As reported',
                'period' => 'Fiscal Annual',
                'default_year_range' => [2005, 2023],
                'unit' => 'Billions',
                'decimalPlaces' => 2,
                'perShareDecimalPlaces' => 1,
                'order' => 'Latest On The Right',
                'freezePane' => 'Top Row & First Column',
            ];
        }

        $this->settings = $settings;
    }

    public function updateSetting($newSettings)
    {
        $this->settings = $newSettings;
        $this->saveSettings();
    }

    public function saveSettings()
    {
        Auth::user()->settings = $this->settings;
        Auth::user()->save();
    }

    public function render()
    {
        return view('livewire.account-settings.data-settings');
    }
}
