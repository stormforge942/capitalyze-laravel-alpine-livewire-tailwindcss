<?php

namespace App\Http\Livewire;

use App\Models\CompanySegmentReport;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use WireElements\Pro\Components\SlideOver\SlideOver;

class CompanySegmentReportSlide extends SlideOver
{
    use WithFileUploads;

    public string $amount;
    public $file;
    public string $link = '';
    public $images = [];
    public string $explanations = '';
    public string $fileName = '';
    public string $path = '';
    public $previousAmount;
    public $fullUrl;
    public $date;

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
        'images' => [
            'array'
        ],
        'images.*' => [
            'image',
            'mimes:jpeg,png,jpg',
            'max:2048'
        ]
    ];

    public function mount($previousAmount, $date, $fullUrl)
    {
        $this->fullUrl = $fullUrl;
        $this->previousAmount = $previousAmount;
        $this->date = $date;
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'images') {
            $this->fileName = $this->images[0]->getClientOriginalName();
            if (count($this->images) > 1) {
                $this->fileName .= ', ' . count($this->images) - 1 . ' more ';
            }

            $this->validateOnly('images.*');
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

        $files_ids = [];

        foreach ($this->images as $image) {
            $path = Storage::disk('s3')->put('/company_segment_reports', $image);
            $file = File::create([
                'user_id' => auth()->id(),
                'path' => $path,
                'url' => Storage::disk('s3')->url($path)
            ]);
            $files_ids[] = $file->id;
        }

        $companySegmentReport = CompanySegmentReport::create([
            'previous_amount' => $this->previousAmount,
            'date' => $this->date,
            'company_url' => $this->fullUrl,
            'amount' => $this->amount,
            'link' => $this->link,
            'explanations' => $this->explanations,
            'user_id' => auth()->id(),
        ]);

        $companySegmentReport->files()->attach($files_ids);

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
