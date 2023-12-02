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
    public $navbarItems;

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

        $this->navbarItems = $this->navbar();
    }

    public function navbar(): array
    {
        return [
            'main' => Navbar::getPrimaryLinks(Auth::user()->navbars())
                ->map(function (Navbar $nav) {
                    return [
                        'title' => $nav->name,
                        'url' => route($nav->route_name, ['ticker' => $this->company->ticker]),
                        'active' => request()->routeIs($nav->route_name)
                    ];
                })
                ->toArray(),
            'company_research' => [
                [
                    'title' => 'Overview',
                    'url' => route('company.profile', ['ticker' => $this->company->ticker]),
                    'active' => request()->routeIs('company.profile', 'company.product')
                ],
                [
                    'title' => 'Financials',
                    'url' => route('company.report', ['ticker' => $this->company->ticker]),
                    'active' => request()->routeIs('company.report')
                ],
                [
                    'title' => 'Analysis',
                    'url' => route('company.analysis', ['ticker' => $this->company->ticker]),
                    'active' => request()->routeIs('company.analysis')
                ],
                [
                    'title' => 'Filings',
                    'url' => route('company.filings-summary', ['ticker' => $this->company->ticker]),
                    'active' => request()->routeIs('company.filings-summary')
                ],
                [
                    'title' => 'Ownership',
                    'url' => route('company.ownership', ['ticker' => $this->company->ticker]),
                    'active' => request()->routeIs('company.ownership', 'company.fund')
                ],
            ]
        ];
    }
}
