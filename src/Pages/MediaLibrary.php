<?php

namespace Filament\Pages;

use Filament\Pages\Actions\ButtonAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Plank\Mediable\Media;
use Closure;

class MediaLibrary extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament::pages.media-library';

    public ?int $selectedMedia = null;

    public bool $bulkSelect = false;

    public bool $showUploadMedia = false;

    protected $listeners = [
        'uppyFileUploaded' => 'onFileUploaded'
    ];

    public function selectMedia(int $mediaId): void
    {
        $this->selectedMedia = $mediaId;
    }

    public function enableBulkSelect()
    {
        $this->bulkSelect = true;
    }

    public function toggleUploadMedia()
    {
        $this->showUploadMedia = !$this->showUploadMedia;
    }

    public function deleteMedia(): void
    {
        if ($this->selectedMedia) {
            $media = Media::find($this->selectedMedia);
            $media->delete();

            $this->selectedMedia = null;

            $this->notify('success', "Media deleted successfully.");
        }

    }

    public function onFileUploaded()
    {
        $this->notify('success', "Media uploaded successfully.");
        $this->callMethod('render');
    }

    public static function getRoutes(): Closure
    {
        return function () {
            Route::get('/media-library', static::class)->name(static::getSlug());
        };
    }

    protected function getActions(): array
    {
        $actions = [
            ButtonAction::make('upload')
                ->label(__("Upload"))
                ->withoutLoadingIndicator()
                ->action('toggleUploadMedia'),
        ];

        if ($this->selectedMedia) {
            $actions[] = ButtonAction::make('deleteSelectedMedia')
                ->color("danger")
                ->label(__('filament::media-library.delete.single'))
                ->action('deleteMedia');
        }

        return $actions;
    }

    public function openSettingsModal(): void
    {
        $this->emitBrowserEvent('open-settings-modal');
    }

    protected function getHeader(): ?View
    {
        return parent::getHeader(); // TODO: Change the autogenerated stub
    }

    protected function getViewData(): array
    {
        return [
            'medias' => Media::query()->latest('created_at')->get()
        ];
    }
}
