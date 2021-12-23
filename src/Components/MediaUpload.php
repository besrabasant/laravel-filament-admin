<?php

namespace Filament\Components;

use Livewire\Component;
use Livewire\WithFileUploads;
use Plank\Mediable\Facades\MediaUploader;

class MediaUpload extends Component
{
    use WithFileUploads;

    public $files = [];


    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'file', // 1MB Max
        ]);

        foreach ($this->files as $file) {
            MediaUploader::fromSource($file)
                ->toDisk('public')
                ->toDirectory(date('Y'))
                ->upload();
        }

        $this->files = [];
    }

    public function render()
    {
        return view("filament::livewire.media-upload");
    }
}
