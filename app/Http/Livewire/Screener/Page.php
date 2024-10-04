<?php

namespace App\Http\Livewire\Screener;

use Livewire\Component;
use App\Models\ScreenerTab;
use Illuminate\Support\Str;
use App\Models\CompanyProfile;
use App\Services\ScreenerTableBuilderService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class Page extends Component
{
    public const SUMMARIES = ['Max', 'Min', 'Sum', 'Median'];

    public const OPERATORS = [
        '>' => 'Greater than (>)',
        '>=' => 'Greater than or equal (>=)',
        '<' => 'Less than (<)',
        '<=' => 'Less than or equal (<=)',
        '=' => 'Equal (=)',
        'between' => 'Between',
    ];

    public $tab = null;
    public $options = null;

    public $universalCriteria = null;
    public $financialCriteria = null;
    public $summaries = [];

    public $data = null;

    public $result = null;

    private $tabCriterias = null;

    public ?array $view = null;

    protected $listeners = [
        'tabChanged',
        'generateResult',
    ];

    public function render()
    {
        if (!$this->options) {
            $options = ['country', 'exchange', 'sic_group', 'sic_description', 'price_currency'];
            foreach ($options as $option) {
                $cacheKey = 'screener_criteria:' . $option;
                $this->options[$option] = Cache::remember(
                    $cacheKey,
                    now()->addHour(),
                    fn() => CompanyProfile::select($option)
                        ->distinct()
                        ->whereNotNull($option)
                        ->pluck($option)
                        ->toArray()
                );
            }
        }

        // fixes the stale data issue
        if ($this->tab) {
            $this->tabChanged([
                'id' => $this->tab['id'],
                'name' => $this->tab['name'],
            ]);
        }

        return view('livewire.screener.page', [
            'dates' => ScreenerTableBuilderService::dataDateRange(),
            '_options' => [
                'summaries' => self::SUMMARIES,
                'operators' => self::OPERATORS,
            ],
            'tabCriterias' => $this->tabCriterias,
        ]);
    }

    public function updatedSummaries($value)
    {
        ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->update(['summaries' => $value]);

        $this->emitTo(Table::class, 'refreshSummary', $value);
    }

    public function tabChanged($tab_)
    {
        $this->tab = $tab_;

        $tab = ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->find($tab_['id']);

        $empty = ['data' => [], 'exclude' => false];

        $universalCriteria = $tab->universal_criteria ?? [];
        $this->universalCriteria = [
            'locations' => data_get($universalCriteria, 'locations', $empty),
            'stock_exchanges' => data_get($universalCriteria, 'stock_exchanges', $empty),
            'industries' => data_get($universalCriteria, 'industries', $empty),
            'sectors' => data_get($universalCriteria, 'sectors', $empty),
            'market_cap' => data_get($universalCriteria, 'market_cap', null),
        ];

        $this->financialCriteria = $tab->financial_criteria ?? [];

        $this->summaries = $tab->summaries ?? [];

        $this->tabCriterias = ScreenerTableBuilderService::resolveValidCriterias($this->universalCriteria, $this->financialCriteria);

        $this->view = null;

        foreach (collect($tab->views ?? []) as $view) {
            if ($view['id'] === $tab->view) {
                $this->view = $view;
                break;
            }
        }
    }

    public function generateResult()
    {
        $data = [
            'universal_criteria' => $this->universalCriteria,
            'financial_criteria' => $this->financialCriteria,
            'summaries' => $this->summaries,
        ];

        $validator = Validator::make($data, [
            'universal_criteria' => ['nullable', 'array'],
            'universal_criteria.locations.exclude' => ['required', 'boolean'],
            'universal_criteria.locations.data' => ['nullable', 'array'],
            'universal_criteria.locations.data.*' => ['string'],
            'universal_criteria.stock_exchanges.exclude' => ['required', 'boolean'],
            'universal_criteria.stock_exchanges.data' => ['nullable', 'array'],
            'universal_criteria.stock_exchanges.data.*' => ['string'],
            'universal_criteria.sectors.exclude' => ['required', 'boolean'],
            'universal_criteria.sectors.data' => ['nullable', 'array'],
            'universal_criteria.sectors.data.*' => ['string'],
            'universal_criteria.industries.exclude' => ['required', 'boolean'],
            'universal_criteria.industries.data' => ['nullable', 'array'],
            'universal_criteria.industries.data.*' => ['string'],
            'universal_criteria.market_cap' => ['nullable', 'array', 'min:2', 'max:2'],
            'universal_criteria.market_cap.*' => ['nullable', 'numeric'],

            'financial_criteria' => ['nullable', 'array'],
            'financial_criteria.*' => ['array'],
            'financial_criteria.*.id' => ['nullable', 'string'],
            'financial_criteria.*.metric' => ['nullable', 'string'],
            'financial_criteria.*.type' => ['nullable', Rule::in(['value', 'changeYoY'])],
            'financial_criteria.*.period' => ['nullable', Rule::in(['annual', 'quarter'])],
            'financial_criteria.*.dates' => ['nullable', 'array'],
            'financial_criteria.*.dates.*' => ['required', 'string'],
            'financial_criteria.*.operator' => ['nullable', Rule::in(array_keys(Page::OPERATORS))],
            'financial_criteria.*.value' => ['nullable'],

            'summaries' => ['nullable', 'array'],
            'summaries.*' => ['required', Rule::in(Page::SUMMARIES)],
        ]);

        $attributes = $validator->validate();

        $where = fn($criteria) => !empty($criteria['metric']) && !empty($criteria['type'] && !empty($criteria['period']) && !empty($criteria['dates']));

        $attributes['financial_criteria'] = collect($attributes['financial_criteria'])
            ->filter($where)
            ->map(fn($item) => [
                ...$item,
                'id' => Str::uuid()->toString(),
            ])
            ->values()
            ->toArray();

        ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->update($attributes);

        $result = ScreenerTableBuilderService::resolveValidCriterias($attributes['universal_criteria'], $attributes['financial_criteria']);

        $this->emitTo(Table::class, 'refreshTable', $result['universal'], $result['financial'], $attributes['summaries']);
    }
}
