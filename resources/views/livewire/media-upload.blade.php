<?php
?>

<div>
    <div x-data>
        <div class="p-1 border-[3px] border-gray-200 border-dashed rounded-lg group hover:cursor-pointer"
             id="mediaLibraryDropzone">
            <div id="mediaLibraryDropzone_Container"
                 class="flex justify-center p-7 group-hover:bg-gray-200 pointer-events-none transition rounded-lg">
                <input type="file" id="mediaLibraryDropzone_FileInput"
                       class="absolute top-0 left-0 right-0 bottom-0 w-full hidden" multiple>
                <span class="text-xl font-medium text-gray-500">
            {{ __('filament::media-library.media-upload.placeholder') }}
            </span>
            </div>
        </div>

        <div x-show="$store.mediaLibrary.showProgress" class="relative pt-3">
            <div class="overflow-hidden h-1.5 mb-4 text-xs flex rounded bg-primary-100">
                <div x-bind:style="{width: `${$store.mediaLibrary.uploadProgress}%`}"
                     class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-500 rounded transition ease-in-out"></div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        var uppy = new Uppy.Core({
            id: "mediaLibraryUpload",
            allowMultipleUploadBatches: true,
        });

        const uploadFiles = (files) => {
            Alpine.store('mediaLibrary').showProgressBar();
            @this.uploadMultiple(
                'files',
                files,
                (uploadedFilenames) => {
                    console.log(uploadedFilenames)
                    @this.emitUp('uppyFileUploaded');
                    uppy.reset();
                }, () => {
                }, (event) => {
                    console.log(event.detail)

                    if (Alpine.store('mediaLibrary').uploadProgress < 100 && event.detail.progress === 100) {
                        event.detail.progress = 0;
                        Alpine.store('mediaLibrary').hideProgressBar()
                    }
                    Alpine.store('mediaLibrary').setUploadProgress(event.detail.progress)
                })
        }

        uppy.use(Uppy.DropTarget, {
            target: '#mediaLibraryDropzone',
            onDragOver: (event) => {
                let dropZoneContainer = event.target.querySelector('#mediaLibraryDropzone_Container')

                if (dropZoneContainer && !dropZoneContainer.classList.contains('bg-gray-200')) {
                    dropZoneContainer.classList.add('bg-gray-200')
                }
            },
            onDragLeave: (event) => {
                let dropZoneContainer = event.target.querySelector('#mediaLibraryDropzone_Container')

                if (dropZoneContainer && dropZoneContainer.classList.contains('bg-gray-200')) {
                    dropZoneContainer.classList.remove('bg-gray-200')
                }
            },
            onDrop: (event) => {
                event.preventDefault()

                let files = uppy.getFiles()

                if (files.length > 0) {
                    files = files.map(file => file.data)
                    uploadFiles(files)
                }

            },
        });

        var mediaLibraryDropzone = document.querySelector('#mediaLibraryDropzone');
        var mediaLibraryDropzone_FileInput = document.querySelector('#mediaLibraryDropzone_FileInput');

        mediaLibraryDropzone.addEventListener('click', (event) => {
            mediaLibraryDropzone_FileInput.click()
        });

        mediaLibraryDropzone_FileInput.addEventListener('change', (event) => {
            const files = Array.from(event.target.files)
            uploadFiles(files)
        })
    </script>
@endpush
