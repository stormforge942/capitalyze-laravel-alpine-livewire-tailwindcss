<?php

namespace App\Http\Livewire;

use App\Models\CompanySegmentReport;
use Livewire\Component;

class ReviewPage extends Component
{
    public $reportId = null;
    public $filesIds = null;
    public $openFileExplorer = false;
    public $openSlider = false;

    protected $listeners = [
        'toggle-slider' => 'toggleSlider',
        'close-slider' => 'closeSlider',
        'images-show' => 'showImages',
        'images-hide' => 'hideImages',
        'change-fixed' => 'changeFixed',
    ];

    public function showImages($p) {
        $this->filesIds = $p;
        $this->openFileExplorer = true;
    }

    public function hideImages() {
        $this->filesIds = [];
        $this->openFileExplorer = false;
    }

    public function toggleSlider($args)
    {
        [$id] = $args;
        if ($id)
        {
            $this->reportId = $args[0];
        }

        $this->openSlider = !$this->openSlider;
    }

    public function closeSlider()
    {
        $this->openSlider = false;
        $this->emit('refresh');
    }

    public function changeFixed($id)
    {
        $companySegmentReport = CompanySegmentReport::where('id', $id)->get()->first();
        $companySegmentReport->fixed = !$companySegmentReport->fixed;
        $companySegmentReport->save();
        $this->emit('refresh');
    }

    public function render()
    {
        return view('livewire.review-page');
    }
}
