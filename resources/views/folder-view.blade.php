<x-app-layout>
    <x-slot name="header" style="margin-bottom: 0px">
    @if($folderId)
    <livewire:fast-search :currentFolderId="$folderId" />
    @else
    @livewire('service-search')
    @endif
        
    </x-slot>
    <livewire:folder-manager :folder-id="$folderId" /> 
</x-app-layout>
