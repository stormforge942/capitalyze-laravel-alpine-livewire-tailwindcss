<?php

namespace App\Http\Livewire;

use App\Models\CompanySegmentReport;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanySegmentReportUpdateSlider extends Component
{
    use WithFileUploads;

    public $reportId;
    public $supportEngineer = null;
    public $supportEngineerComments = null;
    public $fileName;
    public $fixed = null;
    public $deleteOldFiles = true;
    public $images = [];
    public $oldImages = [];

    protected $rules = [
        'supportEngineer' => [
            'nullable',
            'string',
        ],
        'supportEngineerComments' => [
            'nullable',
            'string',
        ],
        'fixed' => [
          'required',
          'boolean'
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


    public function mount($reportId)
    {
        if ($reportId)
        {
            $report = CompanySegmentReport::where('id', $reportId)->first();
            $this->supportEngineer = $report->support_engineer;
            $this->supportEngineerComments = $report->support_engineer_comments;
            $this->fixed = $report->fixed;
            $this->oldImages = $report->reviewFiles;
            $this->reportId = $report->id;
        }
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
        return view('livewire.company-segment-report-update-slider');
    }

    public function submit()
    {
        $this->validate();

        if ($this->deleteOldFiles) {
            $this->oldImages->each(function (File $file) {
                $file->deleteFromBucket();
                $file->delete();
            });
        }

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

         CompanySegmentReport::where('id', $this->reportId)->update([
            'support_engineer' => $this->supportEngineer,
            'support_engineer_comments' => $this->supportEngineerComments,
            'fixed' => $this->fixed,
        ]);

        $companySegmentReport = CompanySegmentReport::where('id', $this->reportId)->first();

        $companySegmentReport->reviewFiles()->attach($files_ids);

        $this->emitTo('review-page', 'close-slider');
    }
}
