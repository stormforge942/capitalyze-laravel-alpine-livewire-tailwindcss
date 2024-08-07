<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Illuminate\Http\Request;
use Livewire\Component;

class InsiderOwnership extends Component
{
    use AsTab;

    protected array $filters = [];
    public string $ticker;
    private array $relationships = [];

    public static function title(): string
    {
        return 'Insider Ownership';
    }

    public function mount(array $data = [], Request $request)
    {
        $this->ticker = $data['company']['ticker'];

        if ($request->query('search')) {
            $this->filters['search'] = $request->query('search');
        }
    }

    public function render()
    {
        return view('livewire.ownership.insider-ownership', [
            'filters' => $this->filters,
        ]);
    }
}
