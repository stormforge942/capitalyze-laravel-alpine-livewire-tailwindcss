<?php

namespace App\Http\Livewire;

use App\Models\Navbar;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class CompanyNavbar extends Component
{
    public $company;
    public $period = "annual";
    public $currentRoute;
    public $groups;

    protected $queryString = [
        'period' => ['except' => 'annual']
    ];

    protected $listeners = ['periodChange' => '$refresh'];

    public function changePeriod($period): RedirectResponse
    {
        $this->period = $period;
        return redirect()->route($this->currentRoute, ['ticker' => $this->company->ticker, 'period' => $period]);
    }

    public function render(): ViewFactory|View|Application
    {
        return view('livewire.company-navbar');
    }

    public function mount(Request $request): void
    {
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }

        $this->groups = $this->navbar();
    }

    public function navbar(): array
    {
        $allLinks = Auth::user()->navbars();
        $links = Navbar::getPrimaryLinks($allLinks)
            ->map(function (Navbar $nav) {
                return [
                    'title' => $nav->name,
                    'url' => route($nav->route_name, ['ticker' => $this->company->ticker]),
                    'active' => request()->routeIs($nav->route_name)
                ];
            });

        $mainLinks = [
            'Track Investor',
            'Event Filings',
            'Insider Transactions',
            'Earnings Calendar',
        ];

        $companyResearchLinks = [
            'Overview',
            'Financials',
            'Analysis',
            'Filings',
            'Ownership',
        ];

        return [
            'main' => [
                'name' => 'Idea Generation',
                'items' => $links->where(fn ($link) => in_array($link['title'], $mainLinks))
                    ->sort($this->sortFunction($mainLinks))
                    ->values()
                    ->all(),
                'collapsed' => false
            ],
            'company_research' => [
                'name' => $this->company->ticker . ' Research',
                'items' => $allLinks->where(fn ($link) => in_array($link['name'], $companyResearchLinks))
                    ->map(function (Navbar $nav) {
                        $active = request()->routeIs($nav->route_name);

                        if ($nav->name === 'Ownership') {
                            $active = $active || request()->routeIs('company.fund', 'company.mutual-fund');
                        }

                        return [
                            'title' => $nav->name,
                            'url' => route($nav->route_name, ['ticker' => $this->company->ticker]),
                            'active' => $active
                        ];
                    })
                    ->sort($this->sortFunction($companyResearchLinks))
                    ->values()
                    ->all(),
                'collapsed' => false
            ],
            'more' => [
                'name' => 'More',
                'items' => $links->where(
                    fn ($link) => !in_array($link['title'], array_merge($mainLinks, $companyResearchLinks))
                )
                    ->values()
                    ->all(),
                'collapsed' => true
            ]
        ];
    }

    private function sortFunction($order)
    {
        return function ($a, $b)  use ($order) {
            $aIndex = array_search($a['title'], $order);
            $bIndex = array_search($b['title'], $order);

            $aIndex = $aIndex === false ? PHP_INT_MAX : $aIndex;
            $bIndex = $bIndex === false ? PHP_INT_MAX : $bIndex;

            return $aIndex <=> $bIndex;
        };
    }
}
