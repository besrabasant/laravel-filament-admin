<div class="flex items-center justify-center min-h-screen bg-secondary-100 text-gray-900">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="authenticate" class="bg-white space-y-8 shadow-lg shadow-secondary-300/40 border border-gray-300 rounded-2xl p-8">
            <div class="w-full flex justify-center">
                <x-filament::brand />
            </div>

            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('filament::login.heading') }}
            </h2>

            {{ $this->form }}

            <x-filament::button type="submit" form="authenticate" class="w-full">
                {{ __('filament::login.buttons.submit.label') }}
            </x-filament::button>
        </form>

        <x-filament::footer />
    </div>
</div>
