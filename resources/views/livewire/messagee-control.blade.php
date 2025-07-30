<div>
    @if ($nombreNewMessage > 0)
        <div wire:poll.20s
            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
            {{ $nombreNewMessage }}
        </div>
    @endif
</div>
