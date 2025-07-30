<div class="mx-auto">
    <!-- Drag Bubble -->
    <div id="drag-bubble"
        class="hidden absolute z-50 pointer-events-none bg-white bg-opacity-75 text-blue-600 border-2 border-dashed border-blue-600 rounded-md px-3 py-1 font-bold text-sm">
    </div>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray overflow-hidden shadow-xl sm:rounded-lg flex items-center space-x-4 p-4">
                <p class="text-lg font-medium text-gray-900 dark:text-white flex-auto">Création nouveau dossier</p>
                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button" id="createDoc"
                    class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-white dark:text-white mr-2" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                            clip-rule="evenodd" />
                    </svg>
                    Nouveau Dossier
                </button>
            </div>

            @include('propriete')
            @include('createFolder')

        </div>
    </div>
    @if ($parentId)
        @livewire('modal-verrou', ['id' => $parentId, 'model' => 'folder'])
    @endif
    <!-- Main modal -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8 relative">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold mb-4">
                @if (strlen($SessionServiceinfo) > 0)
                    <small class="breadcrumb inline-flex items-center">
                        <span class="text-gray-600" id="chemin">Chemin :
                            <a href="#" wire:click="resetFolderPath" class="text-blue-600 inline-flex items-center">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                {{ $SessionServiceinfo->nom }}
                            </a>
                        </span>

                        @foreach ($currentFolder as $index => $folder)
                            <span class="inline-flex items-center">
                                @if ($index > 0)
                                    <svg class="w-6 h-6 text-gray-500 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m10 16 4-4-4-4" />
                                    </svg>
                                @endif
                                <a href="#" wire:click.prevent="navigateToFolder({{ $folder['id'] ?? 'null' }})"
                                    class="text-blue-600 hover:underline">
                                    {{ $folder['name'] }}
                                </a>
                            </span>
                        @endforeach
                    </small>
                @endif

                <span wire:loading wire:target='navigateToFolder, resetFolderPath'>
                    <span role="status">
                        <svg aria-hidden="true" class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                    </span>
                </span>

            </h2>
             <!-- View Toggles -->
             <div class="flex items-center space-x-2">
                <span wire:loading wire:target="setDisplayMode">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-400 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"></path>
                    </svg>
                </span>
                <button wire:click="setDisplayMode('grid')" class="p-2 rounded-md {{ $displayMode === 'grid' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </button>
                <button wire:click="setDisplayMode('list')" class="p-2 rounded-md {{ $displayMode === 'list' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
        @if (count($currentFolder) > 1)
            <div class="flex justify-end p-3">
                <button data-modal-target="uploadFile" data-modal-toggle="uploadFile" type="button"
                    wire:click="infoIdFocus"
                    class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-green-500 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v6.41A7.5 7.5 0 1 0 10.5 22H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Z"
                            clip-rule="evenodd" />
                        <path fill-rule="evenodd"
                            d="M9 16a6 6 0 1 1 12 0 6 6 0 0 1-12 0Zm6-3a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1v-1a1 1 0 0 1 1-1Z"
                            clip-rule="evenodd" />
                    </svg>
                    Ajouter Fichier
                </button>
            </div>
        @endif


        @if (session()->has('message'))
            <div class="p-2 text-sm text-green-700 bg-green-100 rounded">
                {!! session('message') !!}
            </div>
        @endif

        @if (count($folders) > 0 or count($fichiers) > 0)
            <!-- supprimmer la selection -->
            <div id="bulk-delete-bar"
                class="hidden mb-4 p-4 bg-red-100 border border-red-300 rounded-md flex justify-between items-center w-full">

                <div class="flex gap-2 items-center text-red-700 font-semibold">
                    <span><span id="selected-count">0</span> élément(s) sélectionné(s)</span>
                    <button id="select-all" class="underline text-sm hover:text-red-900">Tout sélectionner</button>
                    <button id="deselect-all" class="underline text-sm hover:text-red-900">Tout désélectionner</button>
                </div>

                <button id="delete-selected"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center gap-2">
                    <span>Supprimer la sélection</span> <span wire:loading ">
                                    <span role="status">
                                        <svg aria-hidden="true"
                                            class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d=" M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591
                        0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100
                        50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186
                        73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144
                        27.9921 9.08144 50.5908Z" fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                    </svg>
                    </span>
                    </span>
                </button>
            </div>
            
            @if ($displayMode === 'grid')
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-white relative overflow-y-auto"
                style="max-height: 60vh;">
                @foreach ($folders as $index => $folder)
                    @php
                        $permission = \App\Helpers\AccessHelper::getPermissionFor(auth()->id(), $folder->id);
                    @endphp
                    <div wire:key="folder-{{ $folder->id }}"
                        class="p-2 border-0 rounded iconButton  grid relative click-right w-40 h-32 rounded shadow-md overflow-hidden bg-cover bg-center group hover:scale-105 transition drop-zone draggable-folder"
                        style="background-image: url({{ asset('img/folder.png') }});"
                        data-dropdown-id="dropdownRight-{{ $folder->id }}" data-dropdown-placement="right"
                        data-folder-id="{{ $folder->id }}"
                        data-locked="{{ $folder->verrouille ? 'true' : 'false' }}"
                        draggable="{{ $folder->verrouille ? 'false' : 'true' }}"
                        @if ($folder->verrouille) title="Ce dossier est verrouillé et ne peut pas être déplacé." @endif>
                        <!-- Targeted Loading Indicator -->
                        <div class="loading-overlay hidden absolute top-0 left-0 w-full h-full bg-white bg-opacity-75 justify-center items-center">
                            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                        <!-- selection folder -->
                        @if (!$folder->verrouille && $permission !== 'L')
                            <input type="checkbox" class="checkbox-item hidden" value="{{ $folder->id }}"
                                data-type="folder">
                        @endif


                        <!-- Bouton menu (en haut à droite) -->
                        <div class="flex justify-end">
                            @if ($folder->verrouille)
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                            <button class="text-white hover:text-gray-300 trois-point">
                                <span wire:loading wire:target="deleteFolder">
                                    <span role="status">
                                        <svg aria-hidden="true"
                                            class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="currentColor" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentFill" />
                                        </svg>
                                    </span>
                                </span> ⋮</button>
                        </div>
                        <!-- Badge de permission à gauche -->
                        <div class="flex flex-col space-y-1">
                            @if ($permission === 'L')
                                <small style="font-size: 8px">
                                    🔴
                                </small>
                            @elseif ($permission === 'E')
                                <small style="font-size: 8px">
                                    🟠
                                </small>
                            @elseif ($permission === 'LE')
                                <small style="font-size: 8px">
                                    🟢
                                </small>
                            @else
                                <small style="font-size: 8px">
                                    🚫
                                </small>
                            @endif
                        </div>
                        <a href="{{ route('folders.show', $folder->id) }}" class="text-blue-600 font-semibold">
                            <!-- Nom du dossier (centré ou en bas) -->
                            <div class="text-gray-600 text-sm font-semibold text-center">
                                @if (\Illuminate\Support\Str::length($folder->name) > 45)
                                    {{ \Illuminate\Support\Str::limit($folder->name, 45) }}
                                @else
                                    {{ $folder->name }}
                                @endif
                            </div>
                        </a>
                        <!-- Badges (en bas à gauche) -->
                        <div class="flex justify-between items-center mt-1">
                            <span class="bg-white text-gray-800 text-xs px-2 py-0.5 rounded">
                                📄 {{ $folder->files_count }}
                            </span>
                            <span class="bg-white text-gray-800 text-xs px-2 py-0.5 rounded">
                                📁 {{ $folder->children_count }}
                            </span>
                        </div>
                        <!-- Dropdown menu -->
                        <div id="dropdownRight-{{ $folder->id }}"
                            class="z-10 absolute hidden bg-blue-600 divide-y divide-gray-100  shadow-sm w-44 dark:bg-gray-700">
                            <ul class=" text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownRightButton">
                                {{-- <li style="border-top: solid 1px white">
                                    <small>
                                        <button @if ($folder->verrouille) disabled @endif href="#"
                                            class="block px-4 py-1 text-white hover:bg-gray-600 dark:hover:bg-gray-600 dark:hover:text-white hover:text-white inline-flex flex justify-between items-center w-full"
                                            @click='clickeditfolder'
                                            wire:click="getFolderId({{ $folder->id }})"><span>Renommer</span>
                                            <svg class="w-4 h-4 text-whitedark:text-white hover:text-white "
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </button>
                                    </small>
                                </li> --}}
                                <li style="border-top: solid 1px white">
                                    <small>
                                        <button @if ($folder->verrouille || $permission === 'L') disabled @endif href="#"
                                            class="block px-4 py-1 text-white hover:bg-gray-600 dark:hover:bg-gray-600 dark:hover:text-white hover:text-white inline-flex flex justify-between items-center w-full
                                            @if ($permission === 'L') opacity-50 cursor-not-allowed @endif"
                                            @if ($permission !== 'L') @click='clickeditfolder' wire:click="getFolderId({{ $folder->id }})" @endif>
                                            <span>Renommer</span>
                                            <svg class="w-4 h-4 text-whitedark:text-white hover:text-white "
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </button>
                                    </small>
                                </li>
                                <small>
                                    <li style="border-top: solid 1px white">
                                        <button href="#"
                                            class="block px-4 text-white  py-1 hover:bg-gray-600 hover:text-white  dark:hover:bg-gray-600 dark:hover:text-white inline-flex flex justify-between items-center w-full "
                                            @click="clickModalPropriete"
                                            wire:click="getIds({{ $folder->id }},'folder')"><span>propriété</span><span></span>
                                            <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" />
                                            </svg>
                                        </button>
                                    </li>
                                </small>
                            </ul>
                        </div>
                    </div>
                @endforeach
                @foreach ($fichiers as $file)
                    @php
                        $type = strtolower($file->type);
                        $filePermission = \App\Helpers\AccessHelper::getPermissionFor(auth()->id(), null, $file->id);
                    @endphp

                    <div wire:key="file-{{ $file->id }}" class="p-2 border-0 rounded bg-white grid w-40 h-32 overflow-hidden click-droit-file bg-cover bg-center group hover:scale-105 transition draggable-file"
                        data-dropdown-id="dropdownRight-{{ $file->id }}"
                        data-file-id="{{ $file->id }}" draggable="true"
                        @if ($file->verrouille) title="Ce fichier est verrouillé et ne peut pas être déplacé." @endif
                        style="background-image:  url('@if ($file->type == 'pdf') {{ asset('img/pdf.png') }} @elseif ($type == 'docx' or $type == 'doc') {{ asset('img/word.png') }} @elseif ($type == 'xls' or $type == 'xlsx') {{ asset('img/excel.png') }} @elseif ($type == 'ppt' or $type == 'pptx') {{ asset('img/power.png') }} @elseif ($type == 'csv') {{ asset('img/csv.png') }} @elseif ($type == 'png' || $type == 'jpg' || $type == 'jpeg') {{ asset('img/img.png') }}  @else {{ asset('img/file.png') }} @endif');">
                        <!-- selection file -->
                        @if (!$file->verrouille && $filePermission !== 'L')
                            <input type="checkbox" class="checkbox-item hidden" value="{{ $file->id }}"
                                data-type="file">
                        @endif


                        <a href="/pdf/{{ $file->id }}" class="text-blue-600 font-semibold relative"
                            id="lien-file">
                            <div class="flex justify-between items-start">
                                <!-- Badge de permission -->
                                @if ($filePermission === 'L')
                                    <small style="font-size: 8px">
                                        🔴
                                    </small>
                                @elseif ($filePermission === 'E')
                                    <small style="font-size: 8px">
                                        🟠
                                    </small>
                                @elseif ($filePermission === 'LE')
                                    <small style="font-size: 8px">
                                        🟢
                                    </small>
                                @else
                                    <small style="font-size: 8px">
                                        🚫
                                    </small>
                                @endif
                            </div>
                            <!-- Bouton menu (en haut à droite) -->
                            <div class="flex justify-end">
                                @if ($file->verrouille)
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <span><button class="text-black hover:text-gray-300"> ⋮ </button></span>
                            </div>
                            <div class="text-gray-600 text-sm font-semibold text-center bg-white px-4">
                                <small class="text-xs">
                                    @if (\Illuminate\Support\Str::length($file->nom) > 45)
                                        {{ \Illuminate\Support\Str::limit($file->nom, 45) }}.{{ $type }}
                                    @else
                                        {{ $file->nom }}
                                    @endif
                                </small>
                            </div>

                            <div class="flex  justify-center">
                                @if ($file->type == 'pdf')
                                    <svg class=" text-red-600 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif ($type == 'docx' or $type == 'doc')
                                    <svg class="w-12 h-12 text-blue-200 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M6 16v-3h.375a.626.626 0 0 1 .625.626v1.749a.626.626 0 0 1-.626.625H6Zm6-2.5a.5.5 0 1 1 1 0v2a.5.5 0 0 1-1 0v-2Z" />
                                        <path fill-rule="evenodd"
                                            d="M11 7V2h7a2 2 0 0 1 2 2v5h1a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2H3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h6a2 2 0 0 0 2-2Zm7.683 6.006 1.335-.024-.037-2-1.327.024a2.647 2.647 0 0 0-2.636 2.647v1.706a2.647 2.647 0 0 0 2.647 2.647H20v-2h-1.335a.647.647 0 0 1-.647-.647v-1.706a.647.647 0 0 1 .647-.647h.018ZM5 11a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 9 15.375v-1.75A2.626 2.626 0 0 0 6.375 11H5Zm7.5 0a2.5 2.5 0 0 0-2.5 2.5v2a2.5 2.5 0 0 0 5 0v-2a2.5 2.5 0 0 0-2.5-2.5Z"
                                            clip-rule="evenodd" />
                                        <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                                    </svg>
                                @elseif ($type == 'xls' or $type == 'xlsx')
                                    <svg class="w-12 h-12 text-green-600 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M6 16v-3h.375a.626.626 0 0 1 .625.626v1.749a.626.626 0 0 1-.626.625H6Zm6-2.5a.5.5 0 1 1 1 0v2a.5.5 0 0 1-1 0v-2Z" />
                                        <path fill-rule="evenodd"
                                            d="M11 7V2h7a2 2 0 0 1 2 2v5h1a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2H3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h6a2 2 0 0 0 2-2Zm7.683 6.006 1.335-.024-.037-2-1.327.024a2.647 2.647 0 0 0-2.636 2.647v1.706a2.647 2.647 0 0 0 2.647 2.647H20v-2h-1.335a.647.647 0 0 1-.647-.647v-1.706a.647.647 0 0 1 .647-.647h.018ZM5 11a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 9 15.375v-1.75A2.626 2.626 0 0 0 6.375 11H5Zm7.5 0a2.5 2.5 0 0 0-2.5 2.5v2a2.5 2.5 0 0 0 5 0v-2a2.5 2.5 0 0 0-2.5-2.5Z"
                                            clip-rule="evenodd" />
                                        <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                                    </svg>
                                @elseif ($type == 'csv')
                                    <svg class="w-12 h-12 text-green-400 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006a.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044a.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif ($type == 'png' || $type == 'jpg' || $type == 'jpeg')
                                    <svg class="w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M16 18H8l2.5-6 2 4 1.5-2 2 4Zm-1-8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" />
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m14-4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 18h8l-2-4-1.5 2-2-4L8 18Zm7-8.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" />
                                    </svg>
                                @else
                                    <svg class="w-12 h-12 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 3v4a1 1 0 0 1-1 1H5m4 10v-2m3 2v-6m3 6v-3m4-11v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Dropdown menu pour file-->
                            <div id="dropdownRight-{{ $file->id }}"
                                class="z-10 absolute top-0 hidden  bg-blue-600 divide-y divide-gray-100  shadow-sm w-40 dark:bg-gray-700">
                                <ul class=" text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownRightButton" id="ul">
                                    {{-- <li class="">
                                        <small>
                                            <button @if ($file->verrouille) disabled @endif href="#"
                                                class="block px-4 py-1 text-white hover:bg-gray-600 hover:text-black  dark:hover:bg-gray-600 dark:hover:text-white inline-flex flex justify-between items-center w-full "
                                                @click='clickeditFile'
                                                wire:click="getFileId({{ $file->id }})"><span>Renommer</span><span
                                                    wire:loading wire:target='getFileId'>
                                                    <span role="status">
                                                        <svg aria-hidden="true"
                                                            class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                            viewBox="0 0 100 101" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                fill="currentFill" />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span></span>
                                                <svg class="w-4 h-4 text-white dark:text-white hover:text-white "
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                </svg>
                                            </button>
                                        </small>
                                    </li> --}}


                                    <li style="border-top: solid 1px white">
                                        <button href="#"
                                            class="block px-4 text-white  py-1 hover:bg-gray-600 hover:text-white  dark:hover:bg-gray-600 dark:hover:text-white inline-flex flex justify-between items-center w-full "
                                            @click="clickModalPropriete"
                                            wire:click="getIds({{ $file->id }},'file')"><span>propriété</span><span></span>
                                            <svg class="w-4 h-4 text-white dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" />
                                            </svg>
                                        </button>
                                    </li>

                                    </small>
                                    </li>


                                </ul>
                            </div>
                        </a>
                    </div>
                @endforeach
            @if ($hasMoreFolders || $hasMoreFiles)
                    <div x-data="{}" x-intersect="$wire.loadMore()" class="flex justify-center items-center py-4">
                        <div wire:loading x-show="$hasMoreFolders || $hasMoreFiles" class="flex items-center">
                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"></path>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"></path>
                            </svg>
                            <span class="ml-2 text-gray-500">Chargement...</span>
                        </div>
                    </div>
                @endif
            </div>
            @else
            {{-- LIST VIEW --}}
            <div class="bg-white relative overflow-y-auto" style="max-height: 60vh;">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 sticky top-0">
                        <tr>
                            <th scope="col" class="p-4">
                                <!-- Checkbox placeholder for alignment -->
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center cursor-pointer" wire:click="sortBy('name')">
                                    Nom
                                    @if ($sortBy === 'name')
                                        @if ($sortDirection === 'asc')
                                            <span class="ml-1">&uarr;</span>
                                        @else
                                            <span class="ml-1">&darr;</span>
                                        @endif
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center cursor-pointer" wire:click="sortBy('updated_at')">
                                    Dernière modification
                                    @if ($sortBy === 'updated_at')
                                        @if ($sortDirection === 'asc')
                                            <span class="ml-1">&uarr;</span>
                                        @else
                                            <span class="ml-1">&darr;</span>
                                        @endif
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($folders as $folder)
                            @php
                                $permission = \App\Helpers\AccessHelper::getPermissionFor(auth()->id(), $folder->id);
                            @endphp
                            <tr wire:key="list-folder-{{ $folder->id }}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 drop-zone draggable-folder"
                                data-folder-id="{{ $folder->id }}"
                                data-locked="{{ $folder->verrouille ? 'true' : 'false' }}"
                                draggable="{{ $folder->verrouille ? 'false' : 'true' }}"
                                @if ($folder->verrouille) title="Ce dossier est verrouillé et ne peut pas être déplacé." @endif>
                                <td class="w-4 p-4">
                                    @if (!$folder->verrouille && $permission !== 'L')
                                        <input type="checkbox" class="checkbox-item" wire:model.live="selectedItems" value="{{ $folder->id }}" data-type="folder">
                                    @endif
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ route('folders.show', $folder->id) }}" class="flex items-center" title="{{ $folder->name }}">
                                        {{-- Badge de permission --}}
                                        @if ($permission === 'L')
                                            <small style="font-size: 8px">🔴</small>
                                        @elseif ($permission === 'E')
                                            <small style="font-size: 8px">🟠</small>
                                        @elseif ($permission === 'LE')
                                            <small style="font-size: 8px">🟢</small>
                                        @else
                                            <small style="font-size: 8px">🚫</small>
                                        @endif
                                        <img src="{{ asset('img/folder.png') }}" class="w-6 h-6 mr-2" alt="folder icon">
                                        {{ \Illuminate\Support\Str::limit($folder->name, 45) }}
                                    </a>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $folder->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    Dossier
                                </td>
                                <td class="px-6 py-4">
                                    <div class="action-buttons flex items-center space-x-2">
                                        <button @if ($folder->verrouille || $permission === 'L') disabled @endif
                                            class="px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 @if ($folder->verrouille || $permission === 'L') opacity-50 cursor-not-allowed @endif"
                                            @if ($permission !== 'L') @click='clickeditfolder' wire:click="getFolderId({{ $folder->id }})" @endif>
                                            Renommer
                                        </button>
                                        <button
                                            class="px-3 py-1 text-xs font-medium text-white bg-gray-500 rounded hover:bg-gray-600"
                                            @click="clickModalPropriete"
                                            wire:click="getIds({{ $folder->id }},'folder')">
                                            Propriété
                                        </button>
                                        @if ($folder->verrouille)
                                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="loading-indicator hidden items-center">
                                        <svg class="animate-spin h-5 w-5 text-blue-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span class="ml-2 text-xs">Déplacement...</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($fichiers as $file)
                            @php
                                $type = strtolower($file->type);
                                $filePermission = \App\Helpers\AccessHelper::getPermissionFor(auth()->id(), null, $file->id);
                            @endphp
                             <tr wire:key="list-file-{{ $file->id }}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 draggable-file" data-file-id="{{ $file->id }}" draggable="true" @if ($file->verrouille) title="Ce fichier est verrouillé et ne peut pas être déplacé." @endif>
                                <td class="w-4 p-4">
                                     @if (!$file->verrouille && $filePermission !== 'L')
                                        <input type="checkbox" class="checkbox-item" wire:model.live="selectedItems" value="{{ $file->id }}" data-type="file">
                                    @endif
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="/pdf/{{ $file->id }}" class="flex items-center" title="{{ $file->nom }}">
                                         {{-- Badge de permission --}}
                                        @if ($filePermission === 'L')
                                            <small style="font-size: 8px">🔴</small>
                                        @elseif ($filePermission === 'E')
                                            <small style="font-size: 8px">🟠</small>
                                        @elseif ($filePermission === 'LE')
                                            <small style="font-size: 8px">🟢</small>
                                        @else
                                            <small style="font-size: 8px">🚫</small>
                                        @endif
                                        <img src="@if ($file->type == 'pdf') {{ asset('img/pdf.png') }} @elseif ($type == 'docx' or $type == 'doc') {{ asset('img/word.png') }} @elseif ($type == 'xls' or $type == 'xlsx') {{ asset('img/excel.png') }} @elseif ($type == 'ppt' or $type == 'pptx') {{ asset('img/power.png') }} @elseif ($type == 'csv') {{ asset('img/csv.png') }} @elseif ($type == 'png' || $type == 'jpg' || $type == 'jpeg') {{ asset('img/img.png') }}  @else {{ asset('img/file.png') }} @endif" class="w-6 h-6 mr-2" alt="file icon">
                                       
                                        {{ \Illuminate\Support\Str::limit($file->nom, 45) }}
                                    </a>
                                </th>
                                <td class="px-6 py-4">
                                    {{ $file->updated_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    Fichier {{ strtoupper($type) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="action-buttons flex items-center space-x-2">
                                        <button @if ($file->verrouille || !in_array($filePermission, ['E', 'LE'])) disabled @endif
                                            class="px-3 py-1 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 @if ($file->verrouille || !in_array($filePermission, ['E', 'LE'])) opacity-50 cursor-not-allowed @endif"
                                            @if (!$file->verrouille && in_array($filePermission, ['E', 'LE'])) @click='clickeditFile' wire:click="getFileId({{ $file->id }})" @endif>
                                            Renommer
                                        </button>
                                        <button
                                            class="px-3 py-1 text-xs font-medium text-white bg-gray-500 rounded hover:bg-gray-600"
                                            @click="clickModalPropriete"
                                            wire:click="getIds({{ $file->id }},'file')">
                                            Propriété
                                        </button>
                                        @if ($file->verrouille)
                                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="loading-indicator hidden items-center">
                                        <svg class="animate-spin h-5 w-5 text-blue-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span class="ml-2 text-xs">Déplacement...</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @if ($hasMoreFolders || $hasMoreFiles)
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div x-data="{}" x-intersect="$wire.loadMore()" class="flex justify-center items-center py-4">
                                        <div wire:loading x-show="$hasMoreFolders || $hasMoreFiles" class="flex items-center">
                                           <svg aria-hidden="true"
                        class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
            @endif
        @else
            <div class=" grid grid-cols-1 flex bg-white justify-center " style="padding: 100px;  ">
                <div style="text-align: center">
                    <img class="h-auto max-w-lg mx-auto" src="{{ asset('img/vide.svg') }}" style="height: 100px"
                        alt="image description">
                    vide
                </div>

            </div>
        @endif
    </div>
    <a data-modal-target="uploadFile" data-modal-toggle="uploadFile" class="openModalDoc" id="openModalDoc"></a>
    <a data-modal-target="editFolder" data-modal-toggle="editFolder" class="" id="clickeditFolder"></a>
    <a data-modal-target="editFile" data-modal-toggle="editFile" class="" id="clickeditFile"></a>
    <!-- Main modal -->
    <div id="uploadFile" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" wire:ignore.self
        class="hidden overflow-y-scroll overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                @include('uploaddoc')
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('livewire:initialized', () => {




        function clickdroit() {

            document.querySelectorAll('.trois-point').forEach(function(el) {
                el.addEventListener('click', (event) => {
                    event.stopPropagation(); // Évite que le clic ferme immédiatement

                    // Ferme tous les autres dropdowns
                    document.querySelectorAll('[id^="dropdownRight-"]').forEach(function(drop) {
                        drop.classList.add('hidden');
                    });

                    // Récupère l'ID du menu associé
                    const dropdownId = el.closest('[data-dropdown-id]').getAttribute(
                        'data-dropdown-id');
                    const dropdown = document.getElementById(dropdownId);

                    // Affiche le menu associé
                    if (dropdown) {
                        dropdown.classList.toggle('hidden');
                    }
                });
            });
            //fonction reutiliser pour les clicdroit sur diferent icon folder ou file
            clickDroitIcon('click-right')
            clickDroitIcon('click-droit-file')

            // Fermer les menus au clic ailleurs
            document.addEventListener('click', function(e) {
                document.querySelectorAll('[id^="dropdownRight-"]').forEach(function(drop) {
                    if (!drop.contains(e.target)) {
                        drop.classList.add('hidden');
                    }
                });
            });

            //script pour supprimer un dossier ou un fichier
            document.querySelectorAll("#bouttonDelete").forEach(function(el) {
                el.addEventListener('click', function() {
                    let folderId = (el.getAttribute('data-folder-id'))
                    let doc = (el.getAttribute('data-doc'))
                    console.log(doc)
                    const message = doc === 'folder' ? "Ce dossier et tout son contenu seront supprimés définitivement." : "Ce fichier sera supprimé définitivement.";
                    Swal.fire({
                        title: 'Confirmer la suppression',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const itemToDelete = [{
                                id: folderId,
                                type: doc
                            }];
                            Livewire.dispatch('deleteSelectedItems', {
                                items: itemToDelete
                            });
                        }
                    });
                })
            })


            //document.getElementById('closePropriete').click()
            @this.on('folderDeleted', () => {
                document.getElementById('closePropriete').click()
                Swal.fire({
                    title: 'Supprimé!',
                    text: 'Le dossier a bien été supprimé.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            @this.on('fileDeleted', () => {
                document.getElementById('closePropriete').click()
                Swal.fire({
                    title: 'Supprimé!',
                    text: 'Le Fichier a bien été supprimé.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            const lien_id = document.querySelectorAll('#ul')
            lien_id.forEach((el) => {
                el.addEventListener('click', (
                    e) => { // pour desactiver la redirection vers les affichage du fichier
                    e.preventDefault()
                })
            })
        }
        clickdroit()


        function clickDroitIcon(click) {
            document.querySelectorAll('.' + click).forEach(function(el) {

                // On évite les doubles bindings
                el.removeEventListener('contextmenu', el._contextHandler);

                // Nouveau handler
                el._contextHandler = function(e) {
                    e.preventDefault();

                    // Ferme tous les autres dropdowns
                    document.querySelectorAll('[id^="dropdownRight-"]').forEach(function(drop) {
                        drop.classList.add('hidden');
                    });

                    const dropdownId = el.getAttribute('data-dropdown-id');
                    const dropdown = document.getElementById(dropdownId);
                    if (dropdown) {
                        dropdown.classList.toggle('hidden');
                    }
                };

                el.addEventListener('contextmenu', el._contextHandler);
            });
        }

        function preventDefaults(e) {
            e.preventDefault();
        }
        document.addEventListener('resetJS', function(e) {
            setTimeout(() => {
                clickdroit()

            }, 500);

        })
        document.addEventListener('changeUrl', function(
            event
        ) { //permet d'ecouter evenement changeUrl de son controller et  naviger entre les folder sans rafraichir la page
            history.replaceState(null, '', '/folders/' + event.detail[0].detail);
        });

        @this.on('refreshComponent', () => {
            // Livewire gère déjà le re-rendu, mais si des scripts JS doivent être réinitialisés
            // après un tri, vous pouvez les appeler ici.
            // Par exemple, si vous avez des bibliothèques JS qui manipulent le DOM du tableau.
            // clickdroit(); // Si clickdroit() doit être réexécuté après un tri
            // supressionMultiple(); // Si supressionMultiple() doit être réexécuté après un tri
        });


    })
</script>

<script>
    function supressionMultiple() {
        // NOTE: The logic is now directly inside this function,
        // so it can be re-run after Livewire updates.

        function updateDeleteBar() {
            const checkboxes = document.querySelectorAll('.checkbox-item');
            const checked = Array.from(checkboxes).filter(cb => cb.checked);
            const count = checked.length;

            const bar = document.getElementById('bulk-delete-bar');
            const countSpan = document.getElementById('selected-count');

            if (count > 0) {
                if (bar) bar.classList.remove('hidden');
            } else {
                if (bar) bar.classList.add('hidden');
            }

            if (countSpan) countSpan.textContent = count;
        }

        function initLongPressSelection() {
            document.querySelectorAll('.click-right, .click-droit-file').forEach((el) => {
                let timer = null;

                // Prevents adding multiple listeners to the same element
                if (el.dataset.longPressInitialized) {
                    return;
                }
                el.dataset.longPressInitialized = 'true';

                el.addEventListener('mousedown', () => {
                    timer = setTimeout(() => {
                        document.querySelectorAll('.checkbox-item').forEach(cb => {
                            cb.classList.remove('hidden');
                        });

                        const checkbox = el.querySelector('.checkbox-item');
                        if (checkbox && !checkbox.disabled) {
                            checkbox.checked = true;
                        }

                        updateDeleteBar();
                    }, 1500);
                });

                el.addEventListener('mouseup', () => clearTimeout(timer));
                el.addEventListener('mouseleave', () => clearTimeout(timer));
            });
        }

        function initDeleteButton() {
            const deleteButton = document.getElementById('delete-selected');
            if (!deleteButton || deleteButton.dataset.deleteInitialized) return;
            deleteButton.dataset.deleteInitialized = 'true';

            deleteButton.addEventListener('click', () => {
                const checkboxes = document.querySelectorAll('.checkbox-item:checked');
                const selectedItems = Array.from(checkboxes).map(cb => ({
                    id: cb.value,
                    type: cb.dataset.type
                }));

                if (selectedItems.length > 0) {
                    Swal.fire({
                        title: 'Confirmer la suppression',
                        text: "Tous les éléments sélectionnés seront supprimés définitivement.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deleteSelectedItems', {
                                items: selectedItems
                            });
                        }
                    });
                }
            });
        }

        function initSelectButtons() {
            const selectAllBtn = document.getElementById('select-all');
            const deselectAllBtn = document.getElementById('deselect-all');

            if (selectAllBtn && !selectAllBtn.dataset.selectInitialized) {
                selectAllBtn.dataset.selectInitialized = 'true';
                selectAllBtn.addEventListener('click', () => {
                    document.querySelectorAll('.checkbox-item').forEach(cb => {
                        if (!cb.disabled) {
                            cb.classList.remove('hidden');
                            cb.checked = true;
                        }
                    });
                    updateDeleteBar();
                });
            }

            if (deselectAllBtn && !deselectAllBtn.dataset.selectInitialized) {
                deselectAllBtn.dataset.selectInitialized = 'true';
                deselectAllBtn.addEventListener('click', () => {
                    document.querySelectorAll('.checkbox-item').forEach(cb => {
                        if (!cb.disabled) {
                            cb.checked = false;
                        }
                    });
                    updateDeleteBar();
                });
            }
        }

        // Initialisation
        initLongPressSelection();
        initDeleteButton();
        initSelectButtons();

        document.querySelectorAll('.checkbox-item').forEach(cb => {
            if (cb.dataset.changeInitialized) return;
            cb.dataset.changeInitialized = 'true';
            cb.addEventListener('change', updateDeleteBar);
        });
    }

    // Run on initial page load
    document.addEventListener('DOMContentLoaded', supressionMultiple);

    // Re-run after Livewire updates
    document.addEventListener('resetJS', function() {
        setTimeout(() => {
            supressionMultiple();
        }, 500);
    });
</script>


<script>
    function clickModal() {
        document.getElementById('openModalDoc').click()
    }

    function clickeditfolder() {
        document.getElementById('clickeditFolder').click()
    }

    function clickeditFile() {
        document.getElementById('clickeditFile').click()
    }

    function clickedcreatefolder() {
        document.getElementById('createDoc').click()
    }

    function clickModalPropriete() {
        document.getElementById('propriete').click()
    }
</script>

<script>
    function initDragAndDrop() {
        const bubble = document.getElementById('drag-bubble');
        const transparentPixel = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        const dragImage = new Image();
        dragImage.src = transparentPixel;

        // Update bubble position
        document.addEventListener('dragover', e => {
            if (bubble.style.display === 'block') {
                bubble.style.left = (e.pageX + 15) + 'px';
                bubble.style.top = (e.pageY + 15) + 'px';
            }
        });

        // --- Rendre les éléments déplaçables ---
        const draggableFiles = document.querySelectorAll('.draggable-file');
        draggableFiles.forEach(el => {
            const isLocked = el.querySelector('svg.text-gray-800') !== null;
            const permissionNode = el.querySelector('small');
            const hasNoPermission = permissionNode && (permissionNode.textContent.includes('🔴') || permissionNode.textContent.includes('🚫'));

            if (isLocked || hasNoPermission) {
                el.setAttribute('draggable', 'false');
                el.style.cursor = 'not-allowed';
                return;
            }
            
            el.setAttribute('draggable', 'true');
            el.addEventListener('dragstart', e => {
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setDragImage(dragImage, 0, 0);

                const selectedCheckboxes = document.querySelectorAll('.checkbox-item:checked');
                const isDraggingSelected = el.querySelector('.checkbox-item')?.checked;
                let count = 1;

                if (isDraggingSelected && selectedCheckboxes.length > 1) {
                    // On déplace plusieurs éléments
                    const items = Array.from(selectedCheckboxes).map(cb => ({
                        id: cb.value,
                        type: cb.dataset.type
                    }));
                    e.dataTransfer.setData('items', JSON.stringify(items));
                    count = items.length;
                } else {
                    // On déplace un seul élément
                    e.dataTransfer.setData('type', 'file');
                    e.dataTransfer.setData('id', el.dataset.fileId);
                }

                bubble.textContent = `${count} élément${count > 1 ? 's' : ''} à déplacer`;
                bubble.style.display = 'block';
            });

            el.addEventListener('dragend', () => {
                bubble.style.display = 'none';
            });
        });

        const draggableFolders = document.querySelectorAll('.draggable-folder');
        draggableFolders.forEach(el => {
            el.addEventListener('dragstart', e => {
                e.stopPropagation(); // Empêche les conflits si un dossier est dans un autre
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setDragImage(dragImage, 0, 0);

                const selectedCheckboxes = document.querySelectorAll('.checkbox-item:checked');
                const isDraggingSelected = el.querySelector('.checkbox-item')?.checked;
                let count = 1;

                if (isDraggingSelected && selectedCheckboxes.length > 1) {
                    const items = Array.from(selectedCheckboxes).map(cb => ({
                        id: cb.value,
                        type: cb.dataset.type
                    }));
                    e.dataTransfer.setData('items', JSON.stringify(items));
                    count = items.length;
                } else {
                    e.dataTransfer.setData('type', 'folder');
                    e.dataTransfer.setData('id', el.dataset.folderId);
                }

                bubble.textContent = `${count} élément${count > 1 ? 's' : ''} à déplacer`;
                bubble.style.display = 'block';
            });

            el.addEventListener('dragend', () => {
                bubble.style.display = 'none';
            });
        });

        // --- Gérer les zones de dépôt ---
        const dropZones = document.querySelectorAll('.drop-zone');
        dropZones.forEach(el => {
            el.addEventListener('dragover', e => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                el.classList.add('bg-blue-100', 'border-2', 'border-dashed', 'border-blue-400');
            });

            el.addEventListener('dragleave', e => {
                el.classList.remove('bg-blue-100', 'border-2', 'border-dashed', 'border-blue-400');
            });

            el.addEventListener('drop', e => {
                e.preventDefault();
                e.stopPropagation(); // Important pour les dossiers imbriqués
                el.classList.remove('bg-blue-100', 'border-2', 'border-dashed', 'border-blue-400');

                const itemsJson = e.dataTransfer.getData('items');
                const targetFolderId = el.dataset.folderId;
                const isTargetLocked = el.dataset.locked === 'true';

                if (!targetFolderId) return;

                // --- Client-side loading indicator ---
                function showSpinner(element) {
                    if (!element) return;
                    // For grid view
                    const overlay = element.querySelector('.loading-overlay');
                    if (overlay) {
                        overlay.classList.remove('hidden');
                        overlay.classList.add('flex');
                    }
                    // For list view
                    const indicator = element.querySelector('.loading-indicator');
                    const buttons = element.querySelector('.action-buttons');
                    if (indicator && buttons) {
                        indicator.classList.remove('hidden');
                        indicator.classList.add('flex');
                        buttons.classList.add('hidden');
                    }
                }
                 // --- End of loading indicator logic ---

                if (isTargetLocked) {
                    // Déclenchement instantané du modal côté client
                    Livewire.dispatch('setUnlockTarget', { id: targetFolderId, model: 'folder', context: 'move' });
                }


                showSpinner(el); // Show spinner on target
               

                if (itemsJson) {
                    // --- Moving multiple items ---
                    const items = JSON.parse(itemsJson);
                    items.forEach(item => {
                        const sourceElement = document.querySelector(`[data-${item.type}-id='${item.id}']`);
                        showSpinner(sourceElement);
                    });

                    if (isTargetLocked) {
                        @this.call('prepareMoveToLockedFolder', 'collection', items, targetFolderId);
                    } else {
                        @this.call('moveSelectedItems', items, targetFolderId);
                    }
                } else {
                    // --- Moving a single item ---
                    const type = e.dataTransfer.getData('type');
                    const id = e.dataTransfer.getData('id');
                    if (!id || !type) return;

                    const sourceElement = document.querySelector(`[data-${type}-id='${id}']`);
                    showSpinner(sourceElement);

                    if (isTargetLocked) {
                        @this.call('prepareMoveToLockedFolder', type, id, targetFolderId);
                    } else {
                        if (type === 'file') {
                            @this.call('moveFile', id, targetFolderId);
                        } else if (type === 'folder') {
                            @this.call('moveFolder', id, targetFolderId);
                        }
                    }
                }
            });
        });
    }

    // --- Gestion de la modale de déverrouillage ---
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-unlock-modal-js', () => {
            // Utilise la méthode d'ouverture de la modale existante
            const modalBtn = document.getElementById('modalVerrouBtn');
            if (modalBtn) {
                modalBtn.click();
            }
        });

        Livewire.on('close-unlock-modal-js', () => {
            // Utilise la méthode de fermeture de la modale existante
            const closeBtn = document.getElementById('closeModalVerrou');
            if (closeBtn) {
                closeBtn.click();
            }
        });
    });


    // Initialisation et ré-initialisation
    document.addEventListener('DOMContentLoaded', initDragAndDrop);
    document.addEventListener('resetJS', function() {
        setTimeout(() => {
            initDragAndDrop();
        }, 100);
    });
</script>