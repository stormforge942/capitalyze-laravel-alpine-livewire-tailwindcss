<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Illuminate\Http\Request;
use Livewire\Component;

class ProxyStatement extends Component
{
    use AsTab;

    protected array $filters = [];
    public string $ticker;
    private array $relationships = [];

    public static function title(): string
    {
        return 'Ownership Proxy Statement';
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
        return view('livewire.ownership.proxy-statement', [
            'filters' => $this->filters,
        ]);
    }
}
