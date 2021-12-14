<x-filament::page :widget-record="$record" class="filament-resources-edit-record-page">
    <x-filament::form wire:submit.prevent="save" x-form-locale="{{ $this->activeFormLocale }}">
    <x-filament::form wire:submit.prevent="save">
        {{ $this->form }}

        <x-filament::form.actions :actions="$this->getFormActions()" />
    </x-filament::form>

    @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament::hr />

        <x-filament::resources.relation-managers :active-manager="$activeRelationManager" :managers="$relationManagers" :owner-record="$record" />
    @endif
</x-filament::page>
