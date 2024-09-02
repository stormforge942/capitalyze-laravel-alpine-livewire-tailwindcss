<?php

namespace App\Powergrid;

use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

class BaseTable extends PowerGridComponent
{
    use ActionButton;

    public bool $deferLoading = false;
    public int $perPage = 15;
    public array $perPageValues = [15, 30, 50];

    public $pagination = true;

    public function template(): string
    {
        return CustomTheme::class;
    }

    public function setUp(): array
    {
        $footer = Footer::make();

        if ($this->pagination) {
            $footer->showPerPage($this->perPage, $this->perPageValues)->showRecordCount();
        }

        return [
            Header::make(),
            $footer
        ];
    }

    public function numericColumn(string $title, string $field, string $dataField = '', $sortable = true): Column
    {
        return Column::make($title, $field, $dataField)
            ->sortable($sortable)
            ->headerAttribute('[&>div]:justify-end')
            ->bodyAttribute('text-right');
    }
}
