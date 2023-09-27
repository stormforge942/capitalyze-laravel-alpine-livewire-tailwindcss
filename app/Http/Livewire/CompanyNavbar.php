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
        $this->navbarItems = NavbarGroupShows::query()
            ->with(['navbar'])
            ->where('group_id', Auth::user()->group_id)
            ->where('show', true)
            ->get()
            ->reduce(function ($carry, $item) {
                if (
                    !$item->navbar ||
                    !$item->navbar->is_moddable ||
                    Str::startsWith($item->navbar->route_name, ['company.', 'lse.', 'tsx.', 'fund.', 'otc.', 'mutual-fund.', 'shanghai.', 'japan.', 'hkex.', 'euronext.', 'economics-release', 'create.'])
                ) {
                    return $carry;
                }

                $carry[$item->navbar->id] = $item->navbar;
                return $carry;
            }, collect([]));

        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }
}
