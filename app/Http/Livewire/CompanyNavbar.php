<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\NavbarGroupShows;
use Illuminate\Support\Facades\Auth;

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

    public function changePeriod($period)
    {
        $this->period = $period;
        return redirect()->route($this->currentRoute, ['ticker' => $this->company->ticker, 'period' => $period]);
    }

    public function render()
    {
        return view('livewire.company-navbar');
    }

    public function mount(Request $request)
    {
        $this->navbarItems = $request->user()->navbars()
            ->filter(function ($item) {
                if (
                    !$item->is_moddable ||
                    Str::startsWith($item->route_name, ['company.', 'lse.', 'tsx.', 'fund.', 'otc.', 'mutual-fund.', 'shanghai.', 'japan.', 'hkex.', 'euronext.', 'economics-release', 'create.'])
                ) {
                    return false;
                }

                return true;
            });

        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
