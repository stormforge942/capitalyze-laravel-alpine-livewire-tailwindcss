<?php

namespace App\Http\Livewire;

use App\Models\CompanySegmentReport;
use Illuminate\Support\Facades\Config;
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

    public $pagination = true;

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
        $footer = Footer::make();

        if ($this->pagination) {
            $footer->showPerPage($this->perPage, $this->perPageValues)->showRecordCount();
        }

        return [
            Header::make(),
            $footer,
        ];
    }

    public function editButton($id, $fixed = null)
    {
        if ($fixed === null) {
            return "<button class='btn-primary' wire:click=\"\$emitTo(&quot;review-page&quot;, &quot;toggle-slider&quot;, [" . $id . "])\">Edit</button>";
        }

        $class = $fixed ? 'success' : 'delete';
        $text = $fixed ? 'Yes' : 'No';
        return ("<button class='btn-$class' wire:click=\"\$emitTo(&quot;review-page&quot;, &quot;change-fixed&quot;, [" . $id . " ])\"

        >" .
            $text .
            "</button>");
    }

    public function fixedButton($id, $fixed)
    {
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
            ->addColumn('company_url', function (CompanySegmentReport $companySegmentReport) {
                $link = filter_var($companySegmentReport->company_url, FILTER_VALIDATE_URL)
                    ? $companySegmentReport->company_url
                    : Config::get('app.url') . '/' . $companySegmentReport->company_url;
                return ("<a class='text-blue-500 flex row items-center space-x-2 cursor-pointer' target='_blank' href='$link'>
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-4 h-4'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75' />
                    </svg>
                    <span>Company link</span>
                </a>");
            })
            ->addColumn('amount', fn (CompanySegmentReport $companySegmentReport) => number_format($companySegmentReport->amount))
            ->addColumn('link', function (CompanySegmentReport $companySegmentReport) {
                return $companySegmentReport->link
                    ? ("<a class='text-blue-500' target='_blank' href='$companySegmentReport->link'>Statement link</a>")
                    : 'N/A';
            })
            ->addColumn('images', function (CompanySegmentReport $companySegmentReport) {
                if (!$companySegmentReport->files->count()) {
                    return $this->editButton($companySegmentReport->id);
                }

                $ids = json_encode($companySegmentReport->files->map(fn ($file) => $file->id)->toArray());
                return "<button class='btn-secondary' wire:click=\"\$emitTo(&quot;review-page&quot;, &quot;images-show&quot;, [" . $ids . "])\">Open</button>";
            })
            ->addColumn('explanations')
            ->addColumn('user_name', function (CompanySegmentReport $companySegmentReport) {
                return $companySegmentReport->user->name;
            })
            ->addColumn(
                'support_engineer',
                fn (CompanySegmentReport $companySegmentReport) =>
                strlen($companySegmentReport->support_engineer)
                    ? $companySegmentReport->support_engineer
                    : $this->editButton($companySegmentReport->id)
            )
            ->addColumn(
                'support_engineer_comments',
                fn (CompanySegmentReport $companySegmentReport) =>
                strlen($companySegmentReport->support_engineer_comments)
                    ? $companySegmentReport->support_engineer_comments
                    : $this->editButton($companySegmentReport->id)
            )
            ->addColumn('support_engineer_images', function (CompanySegmentReport $companySegmentReport) {
                if (!$companySegmentReport->reviewFiles->count()) {
                    return $this->editButton($companySegmentReport->id);
                }

                $ids = json_encode($companySegmentReport->reviewFiles->map(fn ($file) => $file->id)->toArray());
                return "<button class='btn-secondary' wire:click=\"\$emitTo(&quot;review-page&quot;, &quot;images-show&quot;, [" . $ids . "])\">Open</button>";
            })
            ->addColumn('fixed_label', function (CompanySegmentReport $companySegmentReport) {
                return $this->editButton($companySegmentReport->id, $companySegmentReport->fixed);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Previous amount', 'previous_amount'),
            Column::make('Date', 'date'),
            Column::make('Page link', 'company_url'),
            Column::make('Amount', 'amount'),
            Column::make('Link', 'link'),
            Column::make('Images', 'images'),
            Column::make('Explanations', 'explanations'),
            Column::make('User name', 'user_name'),
            Column::make('Support engineer', 'support_engineer'),
            Column::make('Support engineer comments', 'support_engineer_comments'),
            Column::make('Support engineer images', 'support_engineer_images'),
            Column::make('Fixed', 'fixed_label'),
        ];
    }
}
