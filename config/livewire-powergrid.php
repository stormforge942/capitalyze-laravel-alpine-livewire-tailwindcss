<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | PowerGrid supports Tailwind and Bootstrap 5 themes.
    | Configure here the theme of your choice.
    */

    'theme' => \PowerComponents\LivewirePowerGrid\Themes\Tailwind::class,
    //'theme' => \PowerComponents\LivewirePowerGrid\Themes\Bootstrap5::class,

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    | Plugins used: bootstrap-select when bootstrap, flatpicker.js to datepicker.
    |
    */

    'plugins' => [
        /*
         * https://github.com/snapappointments/bootstrap-select
         */
        // 'bootstrap-select' => [
        //     'js'  => 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js',
        //     'css' => 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css',
        // ],
        /*
         * https://flatpickr.js.org
         */
        'flatpickr' => [
            'js'      => 'https://cdn.jsdelivr.net/npm/flatpickr',
            'css'     => 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
            'locales' => [
                'en_US' => [
                    'locale'     => 'US',
                    'dateFormat' => 'd/m/Y H:i',
                    'enableTime' => true,
                    'time_24hr'  => true,
                ],
            ],
        ],
        'select' => [
            'default' => 'tom',

            /*
             * TomSelect Options
             * https://tom-select.js.org
             */
            'tom' => [
                'plugins' => [
                    'clear_button' => [
                        'title' => 'Remove all selected options',
                    ],
                ],
            ],

            /*
             * Slim Select options
             * https://slimselectjs.com/
             */
            'slim' => [
                'settings' => [
                    'alwaysOpen' => false,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    |
    | PowerGrid supports inline and outside filters.
    | 'inline': Filters data inside the table.
    | 'outside': Filters data outside the table.
    | 'null'
    |
    */

    'filter' => 'inline',

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Cache is enabled by default to improve search performance when using collections.
    | When enabled, data is reloaded whenever the page is refreshed or a field is updated.
    |
    */

    'cached_data' => false,

    /*
    |--------------------------------------------------------------------------
    | New Release Notification
    |--------------------------------------------------------------------------
    |
    | PowerGrid can verify if a new release is available when you create a new PowerGrid Table.
    |
    | This feature depends on composer/composer.
    | To install, run: `composer require composer/composer --dev`
    |
    */

    'check_version' => true,

        /*
    |--------------------------------------------------------------------------
    | Exportable class
    |--------------------------------------------------------------------------
    |
    |
    */

    'exportable' => [
        'default'      => 'openspout_v4',
        'openspout_v4' => [
            'xlsx' => \PowerComponents\LivewirePowerGrid\Services\OpenSpout\v4\ExportToXLS::class,
            'csv'  => \PowerComponents\LivewirePowerGrid\Services\OpenSpout\v4\ExportToCsv::class,
        ]
    ],

];
