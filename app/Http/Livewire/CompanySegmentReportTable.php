<?php

namespace App\Http\Livewire;

use App\Models\CompanySegmentReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class CompanySegmentReportTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    public bool $deferLoading = false;
    public int $perPage = 50;
    public array $perPageValues = [10, 25, 50];
    public bool $displayLoader = true;

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            [
                'refresh'   => '$refresh',
            ]
        );
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


    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\CompanyInsider>
    */
    public function datasource(): ?Builder
    {
        return CompanySegmentReport::query();
    }


    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('previous_amount', fn (CompanySegmentReport $companySegmentReport) => number_format($companySegmentReport->previous_amount))
            ->addColumn('date')
            ->addColumn('company_url', function(CompanySegmentReport $companySegmentReport) {
                return ("<a class='text-blue-500' target='_blank' href='$companySegmentReport->company_url'>Company</a>");
            })
            ->addColumn('amount', fn (CompanySegmentReport $companySegmentReport) => number_format($companySegmentReport->amount))
            ->addColumn('link', function(CompanySegmentReport $companySegmentReport) {
                return $companySegmentReport->link
                    ? ("<a class='text-blue-500' target='_blank' href='$companySegmentReport->link'>Statement link</a>")
                    : 'N/A';
            })
            ->addColumn('images', function(CompanySegmentReport $companySegmentReport) {
                $response = "";
                foreach ($companySegmentReport->files as $file) {
                    $response .= "<a class='text-blue-500' target='_blank' href='".
                        Storage::disk('s3')->temporaryUrl($file->path, now()->addMinutes(10))
                    ."' $file->url'>file </a>";
                }
                return $response;
            })
            ->addColumn('explanations')
            ->addColumn('user_name', function(CompanySegmentReport $companySegmentReport) {
                return $companySegmentReport->user->name;
            })
            ->addColumn('fixed', function (CompanySegmentReport $companySegmentReport) {
                return ($companySegmentReport->fixed ? 'Yes' : 'No');
            })
            ->addColumn('support_engineer')
            ->addColumn('support_engineer_comments')
            ->addColumn('support_engineer_images', function(CompanySegmentReport $companySegmentReport) {
                $response = "";
                foreach ($companySegmentReport->reviewFiles as $file) {
                    $response .= "<a class='text-blue-500' target='_blank' href='".
                        Storage::disk('s3')->temporaryUrl($file->path, now()->addMinutes(10))
                        ."' $file->url'>file </a>";
                }
                return $response;
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Previous amount', 'previous_amount'),
            Column::make('Date', 'date'),
            Column::make('Company link', 'company_url'),
            Column::make('Amount', 'amount'),
            Column::make('Link', 'link'),
            Column::make('Images', 'images'),
            Column::make('Explanations', 'explanations'),
            Column::make('User name', 'user_name'),
            Column::make('Fixed', 'fixed'),
            Column::make('Support engineer', 'support_engineer'),
            Column::make('Support engineer comments', 'support_engineer_comments'),
            Column::make('Support engineer images', 'support_engineer_images'),
        ];
    }



    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('bg-blue-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->emitTo('review-page', 'toggle-slider', ['id'])
        ];
    }
}
