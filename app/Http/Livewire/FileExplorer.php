<?php

namespace App\Http\Livewire;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FileExplorer extends Component
{

    public $files = [];
    public $isOpen = false;

    public function mount($ids)
    {
        $files = File::whereIn('id', $ids)->get();

        $files->each(
            fn ($file) => $this->files[] = [
                'temporaryUrl' => Storage::disk("s3")->temporaryUrl($file->path, now()->addMinutes(10)),
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
        $allowed_image_types = [
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
            IMAGETYPE_GIF,
            IMAGETYPE_BMP,
            IMAGETYPE_WEBP,
            IMAGETYPE_ICO
        ];

        $image_type = @exif_imagetype($file_path);

        return in_array($image_type, $allowed_image_types);
    }
}



