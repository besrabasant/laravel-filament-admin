@php
    $action = $getAction();
    $url = $getUrl();

    if (! $action) {
        $clickAction = null;
    } elseif ($shouldOpenModal() || ($action instanceof \Closure)) {
        $clickAction = "mountAction('{$getName()}')";
    } else {
        $clickAction = $action;
    }
@endphp

<x-filament::button
    :form="$getForm()"
    :tag="((! $action) && $url) ? 'a' : 'button'"
    :wire:click="$clickAction"
    :href="$url"
    :target="$shouldOpenUrlInNewTab() ? '_blank' : null"
    :type="$canSubmitForm() ? 'submit' : 'button'"
    :color="$getColor()"
    :icon="$getIcon()"
    :icon-position="$getIconPosition()"
    :with-loading-indicator="$getWithLoadingIndicator()"
    class="filament-page-button-action"
>
    {{ $getLabel() }}
</x-filament::button>
