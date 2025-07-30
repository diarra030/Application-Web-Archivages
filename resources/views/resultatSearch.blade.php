<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Resultats de la recheche') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="documents-container" class="mt-6">
                @if($documents->count() > 0)
                    <table class="min-w-full table-auto border-collapse border border-gray-200 shadow-lg rounded-lg overflow-hidden">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium uppercase">Nom</th>
                                <th class="px-6 py-4 text-left text-sm font-medium uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-sm font-medium uppercase">Taille</th>
                                <th class="px-6 py-4 text-left text-sm font-medium uppercase">Date d'ajout</th>
                                <th class="px-6 py-4 text-left text-sm font-medium uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                            @foreach ($documents as $document)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $document->nom }}</td>
                                    <td class="px-6 py-4">{{ $document->type }}</td>
                                    <td class="px-6 py-4">{{ number_format($document->taille / 1024, 2) }} Ko</td>
                                    <td class="px-6 py-4">{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 space-x-3 inline-flex">
                                        <a href="{{ asset('storage/' . $document->filename) }}" target="_blank" class="text-blue-500 hover:underline">Ouvrir</a>
                                        <span class="text-gray-400">|</span>
                                        <a href="#" onclick="printDocument('{{ asset('storage/' . $document->filename) }}')" class="text-green-500 hover:underline">Imprimer</a>
                                        <span class="text-gray-400">|</span>
                                        <a data-tooltip-target="tooltip-animation {{ $document->id }}"  href="{{ route('tag', $document->id) }}">
                                            <svg class="w-6 h-6 text-blue-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M3 5.983C3 4.888 3.895 4 5 4h14c1.105 0 2 .888 2 1.983v8.923a1.992 1.992 0 0 1-2 1.983h-6.6l-2.867 2.7c-.955.899-2.533.228-2.533-1.08v-1.62H5c-1.105 0-2-.888-2-1.983V5.983Zm5.706 3.809a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Zm2.585.002a1 1 0 1 1 .003 1.414 1 1 0 0 1-.003-1.414Zm5.415-.002a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                        <div id="tooltip-animation {{ $document->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            Laisser un message
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $documents->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-500 text-sm">Aucun document trouvé pour cette recherche.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function printDocument(url) {
            const win = window.open(url, '_blank');
            win.print();
        }
    </script>


</x-app-layout>
