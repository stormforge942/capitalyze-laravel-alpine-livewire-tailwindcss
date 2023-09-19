<?php

namespace App\Http\Livewire;

use App\Models\CompanySegmentReport;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use WireElements\Pro\Components\SlideOver\SlideOver;

class CompanySegmentReportSlide extends SlideOver
{
    use WithFileUploads;

    public string $amount;
    public string $link = '';
    public $image;
    public string $explanations = '';
    public string $fileName = '';
    public string $path = '';

    protected $rules = [
        'amount' => [
            'required',
            'min:0.01',
            'numeric',
        ],
        'link' => [
            'nullable',
            'string',
            'url',
        ],
        'explanations' => [
            'nullable',
            'string',
        ],
        'image' => [
            'nullable',
            'image',
            'mimes:jpeg,png',
            'max:2048'
        ],
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'image') {
            $this->fileName = $this->image->getClientOriginalName();
        }

        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.company-segment-report-slide');
    }

    public function submit()
    {
        $this->validate();

        if ($this->image) {
            $this->path = Storage::disk('s3')->put('/company_segment_reports', $this->image);
        }

        CompanySegmentReport::create([
            'amount' => $this->amount,
            'link' => $this->link,
            'image_path' => $this->path,
            'explanations' => $this->explanations,
            'user_id' => auth()->id(),
        ]);

        $this->emit('slide-over.close');
    }

    public static function behavior(): array
    {
        return [
            'close-on-escape' => true,
            'close-on-backdrop-click' => true,
            'trap-focus' => true,
            'remove-state-on-close' => false,
        ];
    }

    public static function attributes(): array
    {
        return [
            'size' => 'xl',
        ];
    }
}
