<?php

namespace App\Http\Livewire\Screener;

use App\Http\Livewire\Screener\Page;
use App\Models\ScreenerTab;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScreenerTabs extends Component
{
    public int $activeTab = 0;
    public array $tabs = [];
    public string $addBtnLabel = 'New Screener';

    public function mount(Request $request)
    {
        $cols = ['id', 'name'];

        $this->tabs = ScreenerTab::query()
            ->where('user_id', Auth::id())
            ->oldest()
            ->get($cols)
            ->toArray();

        if (!count($this->tabs)) {
            $this->tabs[] = ScreenerTab::query()
                ->where('user_id', Auth::id())
                ->create([
                    'name' => 'Untitled',
                    'user_id' => Auth::id(),
                ])
                ->only($cols);
        }

        if (!$this->activeTab) {
            $activeTab = $request->query('tab', ScreenerTab::query()->where('user_id', Auth::id())->latest()->first()->id);

            $this->activeTab = $activeTab && Arr::first($this->tabs, fn($tab) => $tab['id'] == $activeTab)
                ? $activeTab
                : $this->tabs[count($this->tabs) - 1]['id'];
        }
    }

    public function init()
    {
        $tab = Arr::first($this->tabs, fn($tab) => $tab['id'] == $this->activeTab);

        $this->emitTo(Page::class, 'tabChanged', $tab);
    }

    public function render()
    {
        return view('livewire.screener.screener-tabs');
    }

    public function addTab()
    {
        $cols = ['id', 'name'];

        $this->tabs[] = ScreenerTab::query()
            ->where('user_id', Auth::id())
            ->create([
                'name' => 'Untitled',
                'user_id' => Auth::id(),
            ])
            ->only($cols);

        $this->changeTab($this->tabs[count($this->tabs) - 1]['id']);
    }

    public function changeTab($id)
    {
        $tab = Arr::first($this->tabs, fn($tab) => $tab['id'] == $id);

        abort_if(!$tab, 403);

        if ($this->activeTab != $id) {
            $this->emitTo(Page::class, 'tabChanged', $tab);
        }

        $this->activeTab = $id;
    }

    public function updateTab($id, $name)
    {
        abort_if(!Arr::first($this->tabs, fn($tab) => $tab['id'] == $id), 403);

        ScreenerTab::query()
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->update(['name' => $name]);

        foreach ($this->tabs as $idx => $tab) {
            if ($tab['id'] == $id) {
                $this->tabs[$idx]['name'] = $name;
                break;
            }
        }
    }

    public function deleteTab($id)
    {
        abort_if(!Arr::first($this->tabs, fn($tab) => $tab['id'] == $id), 403);

        ScreenerTab::query()
            ->where('id', $id)
            ->delete();

        $this->tabs = array_values(array_filter($this->tabs, fn($tab) => $tab['id'] != $id));

        if (!count($this->tabs)) {
            $this->addTab();
            return;
        }

        if ($this->activeTab == $id) {
            $this->changeTab($this->tabs[count($this->tabs) - 1]['id']);
        }
    }
}
