<x-filament::page>
    <div class="flex">
        <div class="w-[240px]">
            {{--            TODO: Translate --}}
            Directory
        </div>
        <div class="flex-1">
            <div class="@unless($showUploadMedia) hidden @endunless">
                <livewire:filament.core.media-library.media-upload>
                </livewire:filament.core.media-library.media-upload>
            </div>

            <div class="pt-8 grid grid-cols-7 gap-4">
                @foreach($medias as $media)
                    @php
                        /**
                         * @var \Plank\Mediable\Media $media
                         * @var ?int $selectedMedia
                         */
                        $mediaItemClasses = \Illuminate\Support\Arr::toCssClasses([
                            'ring-2 ring-primary-600' => $media->id == $selectedMedia
                        ]);
                    @endphp

                    <div
                        class="aspect-square overflow-hidden p-2 border border-gray-200 cursor-pointer {{ $mediaItemClasses }}"
                        wire:click="selectMedia({{$media->id}})">
                        <img src="{{$media->getUrl()}}" alt=""
                             class="aspect-square object-contain object-center">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament::page>
