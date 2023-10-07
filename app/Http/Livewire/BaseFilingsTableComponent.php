<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

abstract class BaseFilingsTableComponent extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false;
    public string $sortField = 'updated_at';
    public string $sortDirection = 'desc';
    public int $perPage = 25;
    public array $perPageValues = [10, 25, 50];
    public bool $displayLoader = true;
    public $model;

    abstract public function data(): ?Builder;

    public function setUp(): array
    {
        return [
            Header::make(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    public function datasource()
    {
        return $this->data();
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent();
    }

    public function columns(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [];
    }
}
