<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseNavbarComponent extends Component
{
    public Model $model;
    public ?string $currentRoute = null;

    public string $period = "annual";

    public Collection $topNav;
    public Collection $bottomNav;

    protected $queryString = [
        'period' => ['except' => 'annual']
    ];

    protected $listeners = ['periodChange' => '$refresh'];

    abstract public function bottomNavKey(): string;

    public function mount(Request $request)
    {
        $this->registerNavs($request->user());

        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }

    public function render()
    {
        return view('livewire.base-navbar');
    }

    public function changePeriod($period)
    {
        $this->period = $period;
        return redirect()->route(
            $this->currentRoute,
            ['ticker' => $this->model->symbol, 'period' => $period]
        );
    }

    public function registerNavs(User $user): void
    {
        $navItems = $user->navbars();

        $this->topNav = \App\Models\Navbar::getPrimaryLinks($navItems);

        $this->bottomNav = $navItems->where(function ($nav) {
            return Str::startsWith($nav->route_name, $this->bottomNavKey());
        });
    }
}
