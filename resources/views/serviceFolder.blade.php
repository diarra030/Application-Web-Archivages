<x-app-layout>
    <x-slot name="header" style="margin-bottom: 0px">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __( $serviceName->nom) }}
        </h2>
        @livewire('fast-search')
    </x-slot>
    @livewire('folder-manager', ['services'=>$serviceName])
</x-app-layout>