<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataSettings extends Component
{
    use AsTab;

    public $data_settings_columns = [
        'view' => [
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
        'period' => [
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
        'unit' => [
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
        'order' => [
            'title' => 'Order',
            'description' => 'Enterprise',
            'options' => [
                'Latest on the Right' => 'Latest on the Right',
                'Latest on the Left' => 'Latest on the Left',
            ],
        ],
        'freezePane' => [
            'title' => 'Freeze Panes',
            'description' => 'Enerprise',
            'options' => [
                'Top Row' => 'Top Row',
                'First Column' => 'First Column',
                'Top Row & First Column' => 'Top Row & First Column',
            ],
        ],
        'publicView' => [
            'title' => 'Public View',
            'description' => 'Show or hide review button',
            'options' => [
                'yes' => 'Yes',
                'no' => 'No',
            ]
        ],
    ];

    public $settings;

    public function mount()
    {
        $settings = Auth::user()->settings ?? [];

        $settings['publicView'] = data_get($settings, 'publicView', true) ? 'yes' : 'no';

        $this->settings = array_merge([
            'view' => 'As reported',
            'period' => 'Fiscal Annual',
            'defaultYearRange' => [2005, 2023],
            'unit' => 'Billions',
            'decimalPlaces' => 1,
            'perShareDecimalPlaces' => 2,
            'percentageDecimalPlaces' => 2,
            'order' => 'Latest on the Right',
            'freezePane' => 'Top Row & First Column',
            'publicView' => 'yes',
        ], $settings);

        // If not set default value, set default value
        $this->updateSetting($this->settings);
    }

    public function updateSetting($settings)
    {
        $settings['publicView'] = $settings['publicView'] === 'yes';

        Auth::user()->update(['settings' => $settings]);
    }

    public function render()
    {
        return view('livewire.account-settings.data-settings');
    }
}
