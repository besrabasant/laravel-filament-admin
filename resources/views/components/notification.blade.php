@props([
    'message',
    'status',
])

<div
    x-data="{ isVisible: false }"
    x-init="() => {
        $nextTick(() => isVisible = true)
        setTimeout(() => isVisible = false, 5000)
        setTimeout(() => $el.remove(), 6000)
    }"
    x-cloak
    class="fixed inset-x-0 bottom-0 right-0 z-10 p-3 pointer-events-none"
>
    <div class="flex flex-col h-auto sm:max-w-xs max-w-screen ml-auto space-y-2 pointer-events-auto">
        <div
            x-show="isVisible"
            x-transition
            @class([
                'flex items-start px-3 py-2 space-x-2 text-xs shadow ring-2 rounded backdrop-blur-xl backdrop-saturate-150',
                match ($status) {
                    'danger' => 'bg-danger-500 ring-danger-500',
                    'success' => 'bg-success-500 ring-success-500',
                    'warning' => 'bg-warning-500 ring-warning-500',
                    default => 'bg-gray-100 ring-gray-300',
                },
            ])
        >
            <x-dynamic-component :component="match ($status) {
                'danger' => 'heroicon-o-x-circle',
                'success' => 'heroicon-o-check-circle',
                'warning' => 'heroicon-o-exclamation',
                default => 'heroicon-o-information-circle',
            }" :class="\Illuminate\Support\Arr::toCssClasses([
                'shrink-0 w-6 h-6',
                match ($status) {
                    'danger' => 'text-white',
                    'success' => 'text-white',
                    'warning' => 'text-white',
                    default => 'text-gray-900',
                },
            ])"/>

            <div class="flex-1 space-y-1">
                <div class="flex items-center justify-between font-medium">
                    <p
                        @class([
                            'text-sm leading-6',
                            match ($status) {
                                'danger' => 'text-white',
                                'success' => 'text-white',
                                'warning' => 'text-white',
                                default => 'text-gray-900',
                            },
                        ])
                    >
                        {{ $message }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
