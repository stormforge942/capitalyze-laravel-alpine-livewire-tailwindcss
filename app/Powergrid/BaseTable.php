<?php

namespace App\Powergrid;

use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class BaseTable extends PowerGridComponent
{
    use ActionButton;

    public bool $deferLoading = false;
    public int $perPage = 10;
    public array $perPageValues = [10, 25, 50];

    public function template(): string
    {
        return CustomTheme::class;
    }

    public function setUp(): array
    {
        return [
            Header::make(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }
}
