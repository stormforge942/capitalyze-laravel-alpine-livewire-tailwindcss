<?php

namespace App\Http\Livewire;

use App\Models\Navbar;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;

class CompanyNavbar extends Component
{
    public $company;
    public $currentRoute;
    public $groups;

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
                    'active' => request()->routeIs($nav->route_name),
                ];
            });

        $mainLinks = [
            'Track Investors',
            'Events Tracker',
            'Insider Transactions',
            'Earnings Calendar',
            'Screener'
        ];

        $companyResearchLinks = [
            'Overview',
            'Financials',
            'Analysis',
            'Filings',
            'Ownership',
        ];

        $builderLinks = [
            'Chart',
            'Table',
        ];

        $items = [
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
            'builder' => [
                'name' => 'Builder',
                'items' => $allLinks->where(fn ($link) => in_array($link['name'], $builderLinks))
                    ->map(function (Navbar $nav) {
                        return [
                            'title' => $nav->name,
                            'url' => route($nav->route_name, ['ticker' => $this->company->ticker]),
                            'active' => request()->routeIs($nav->route_name)
                        ];
                    })
                    ->sort($this->sortFunction($builderLinks))
                    ->values()
                    ->all(),
                'collapsed' => false
            ],
            'more' => [
                'name' => 'More',
                'items' => $links->where(
                    fn ($link) => !in_array($link['title'], array_merge($mainLinks, $companyResearchLinks, $builderLinks))
                )
                    ->values()
                    ->all(),
                'collapsed' => true
            ]
        ];

        return array_filter($items, fn ($item) => count($item['items']) > 0);
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
