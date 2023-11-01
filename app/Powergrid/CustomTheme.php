<?php

namespace App\Powergrid;

use PowerComponents\LivewirePowerGrid\Themes\Theme;
use PowerComponents\LivewirePowerGrid\Themes\Tailwind;
use PowerComponents\LivewirePowerGrid\Themes\Components\Cols;
use PowerComponents\LivewirePowerGrid\Themes\Components\Table;

class CustomTheme extends Tailwind
{
    public string $name = 'tailwind';

    public bool $rightAlign = true;

    public function table(): Table
    {
        return Theme::table('w-full text-right bg-white rounded-md overflow-clip')
            ->div('my-3 bg-white shadow-lg rounded-lg relative')
            ->thead('font-sm font-semibold capitalize bg-[#E6E6E680] rounded-t-md')
            ->th('pl-6 py-2 text-dark whitespace-nowrap first:flex first:text-left last:pr-6')
            ->tbody('divide-y-2')
            ->tdBody('pl-6 py-4 whitespace-nowrap first:text-left last:pr-6')
            ->tdBodyEmpty('text-center py-4 text-dark-light');
    }

    public function cols(): Cols {
        return Theme::cols()
            ->div('select-none justify-end')
            ->clearFilter('', '');
    }
}
