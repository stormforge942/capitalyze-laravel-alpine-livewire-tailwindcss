<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SingleFileUploader extends Component
{
    use WithFileUploads;

    public $name;
    public $fileName = '';
    public $file;

    public function mount($name)
    {
        $this->name = $name;
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'file') {
            $this->fileName = $this->file->getClientOriginalName();
        }
    }

    public function uploadMultiple($file){
        dd($file);
    }

    public function render()
    {
        return view('livewire.single-file-uploader');
    }
}
