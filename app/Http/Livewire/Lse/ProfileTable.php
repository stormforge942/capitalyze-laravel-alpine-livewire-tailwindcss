<?php

namespace App\Http\Livewire\Lse;

use App\Models\LseProfile;
use App\Http\Livewire\BaseLseProfileTableComponent;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class ProfileTable extends BaseLseProfileTableComponent
{
    public function data(): ?Builder
    {
        return LseProfile::query()
            ->where('symbol', '=', $this->model->symbol);
    }

    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('registrant_name')
            ->addColumn('phone_number')
            ->addColumn('website')
            ->addColumn('security_type')
            ->addColumn('updated_at')
            ->addColumn('url', function (LseProfile $lseProfile) {
                return ('<a class="text-blue-500" target="_blank"  href="'.$lseProfile->url.'">More Info</a>');
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Registrant Name', 'registrant_name')->sortable(),
            Column::make('Phone Number', 'phone_number')->sortable(),
            Column::make('Website', 'website')->sortable(),
            Column::make('security_type', 'security_type')->sortable(),
            Column::make('Updated At', 'updated_at')->sortable(),
            Column::make('URL', 'url')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('registrant_name', 'registrant_name')->operators([]),
            Filter::inputText('phone_number', 'phone_number')->operators([]),
            Filter::inputText('website', 'website')->operators([]),
            Filter::inputText('security_type', 'security_type')->operators([]),
            Filter::inputText('updated_at', 'updated_at')->operators([]),
            Filter::inputText('url', 'url')->operators([]),
        ];
    }
}
