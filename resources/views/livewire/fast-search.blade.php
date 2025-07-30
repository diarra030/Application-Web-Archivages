<div class="relative">

    <style>
        #result {
            position: absolute;
            top: 100%;
            /* Positionner juste en dessous de la barre de recherche */
            left: 0;
            right: 0;
            z-index: 10;
            /* Assurez-vous que cette valeur est supérieure à celle des autres éléments */
            width: 100%;
            /* Ajustez la largeur selon vos besoins */
        }
    </style>

    <div>
        <div class="max-w-2xl mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input id="dropdownNotificationButton" wire:model.live="query"  readonly
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Rechercher un document" required />
                <div wire:loading wire:target="query, fileType, uploadDate, searchType, searchInCurrentFolderOnly" role="status"
                    style="position:absolute; top:15px; right:40px">
                    <svg aria-hidden="true"
                        class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Chargement...</span>
                </div>
            </div>
            <div class="flex justify-between items-center mt-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="showAdvancedSearch" class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"><small>Recherche avancée</small></span>
                </label>
            </div>

            <div x-data="{ show: @entangle('showAdvancedSearch') }" x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2" class="mt-4">
                <div class="mt-4">
                    @if ($currentFolderId)
                        <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.live="searchInCurrentFolderOnly" class="sr-only peer">
                        <div
                            class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"> <small>Recherche dans le dossier</small> </span>
                        </label>
                        <br>
                    @endif
                    <span class="text-gray-700 font-semibold">Rechercher</span>
                    <div class="mt-2 space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" wire:model.live="searchType"  value="all">
                            <span class="ml-2">Tout</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" wire:model.live="searchType"  value="documents">
                            <span class="ml-2">Documents uniquement</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" wire:model.live="searchType"  value="folders">
                            <span class="ml-2">Dossiers uniquement</span>
                        </label>
                    </div>
                </div>
                <div class="flex space-x-4 mt-4">
                    <select wire:model.live="fileType"
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Tous les types</option>
                        <option value="pdf">PDF</option>
                        <option value="docx">DOCX</option>
                        <option value="xlsx">XLSX</option>
                        <option value="pptx">PPTX</option>
                        <option value="csv">CSV</option>
                        <option value="png">PNG</option>
                        <option value="jpeg">JPEG</option>
                        <option value="txt">TXT</option>
                    </select>
                    <input wire:model.live="uploadDate" type="date" class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
        </div>

    </div>

    @if ($query)
        <div id="result"
            class=" overflow-y-scroll h-60 max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">

            @if ((Auth::user()->role->nom === 'SuperAdministrateur') | (Auth::user()->role->nom === 'Administrateur'))
                <h2 class="text-xl font-bold mb-4 text-gray-700 space-x-2">Resultats de la recherche :
                    {{ count($documents) + count($folders) }}
                </h2>
                <ul class="divide-y divide-gray-200">
                    @forelse ($folders as $item)
                        <a href="{{ route('folders.show', $item->id) }}">
                            <button
                                class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex space-x-2">
                                📁- {{ $item->name }}
                            </button>
                        </a>
                    @empty
                    @endforelse
                    @forelse ($documents as $item)
                        <a href="{{ route('pdf.view', $item->id) }}">
                            <button
                                class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex flex-col items-start space-x-2 overflow-scroll">
                                <div class="flex items-center">
                                    @if ($item->type == 'pdf')
                                        <span>
                                            <svg class="w-6 h-6 text-red-500 dark:text-red-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                    <p class="ml-2">{{ $item->nom }}</p>
                                </div>
                                @if(isset($formattedDocuments[$item->id]['content']))
                                    <p class="text-xs text-gray-500 mt-1 truncate text-left " style="max-width:100%" >
                                        ...{!! $formattedDocuments[$item->id]['content'] !!}...
                                    </p>
                                @endif
                            </button>
                        </a>
                    @empty
                        @if(count($folders) == 0)
                            <li class="py-3 text-gray-600"> Aucun resultat </li>
                        @endif
                    @endforelse
                </ul>
            @else
                <h2 class="text-xl font-bold mb-4 text-gray-700 space-x-2">Resultats de la recherche :
                    {{ count($documents) + count($folders) }}
                </h2>
                <ul class="divide-y divide-gray-200">
                     @forelse ($folders as $item)
                        <a href="{{ route('folders.show', $item->id) }}">
                            <button
                                class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex space-x-2">
                                📁- {{ $item->name }}
                            </button>
                        </a>
                    @empty
                    @endforelse
                    @forelse ($documents as $item)
                        <a href="{{ route('pdf.view', $item->id) }}">
                            <button
                                class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex flex-col items-start space-x-2">
                                <div class="flex items-center">
                                    @if ($item->type == 'pdf')
                                        <span>
                                            <svg class="w-6 h-6 text-red-500 dark:text-red-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                    <p class="ml-2">{{ $item->nom }}</p>
                                </div>
                                @if(isset($formattedDocuments[$item->id]['content']))
                                    <p class="text-xs text-gray-500 mt-1 truncate text-left">
                                        ...{!! $formattedDocuments[$item->id]['content'] !!}...
                                    </p>
                                @endif
                            </button>
                        </a>
                    @empty
                        @if(count($folders) == 0)
                            <li class="py-3 text-gray-600"> Aucun resultat </li>
                        @endif
                    @endforelse
               </ul>
            @endif
        </div>
    @endif
</div>
<script>
    setTimeout(() => {
        document.getElementById("dropdownNotificationButton").removeAttribute('readonly');
    }, 1000);
    
</script>
