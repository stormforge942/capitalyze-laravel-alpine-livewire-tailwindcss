<?php

namespace App\Http\Livewire;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;

class FileExplorer extends Component
{

    public $files = [];
    public $isOpen = false;

    public function mount($ids)
    {
        $files = File::whereIn('id', $ids)->get();

        $files->each(
            fn ($file) => $this->files[] = [
                'temporaryUrl' => Storage::disk("s3")->url($file->path),
                'path' => $file->path,
                'name' => basename($file->path),
                'isImage' => $this->isImage($file->path)
            ]
        );

        $this->isOpen = true;
    }

    public function render()
    {
        return view('livewire.file-explorer');
    }

    function isImage($file_path) {
        $mimeType = Storage::disk("s3")->mimeType($file_path);
        return strpos($mimeType, 'image/') === 0;
    }
}



