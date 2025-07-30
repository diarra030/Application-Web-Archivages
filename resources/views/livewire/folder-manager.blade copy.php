
<div class="mx-auto">
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
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-white relative overflow-auto"
                style="height: 60vh ">
                @foreach ($folders as $index => $folder)
                    @php
                        $permission = \App\Helpers\AccessHelper::getPermissionFor(auth()->id(), $folder->id);
                    @endphp
                    <div wire:key={{ $index }}
                        class="p-2 border-0 rounded iconButton  grid relative click-right w-40 h-32 rounded shadow-md overflow-hidden bg-cover bg-center group hover:scale-105 transition"
                        style="background-image: url({{ asset('img/folder.png') }});"
                        data-dropdown-id="dropdownRight-{{ $folder->id }}" data-dropdown-placement="right">
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
                                <span>
                                    👁️
                                </span>
                            @elseif ($permission === 'E')
                                <span>
                                    ✏️
                                </span>
                            @elseif ($permission === 'LE')
                                <span>
                                    📝
                                </span>
                            @else
                                <span>
                                    🚫
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('folders.show', $folder->id) }}" class="text-blue-600 font-semibold">
                            <!-- Nom du dossier (centré ou en bas) -->
                            <div class="text-gray-600 text-sm font-semibold text-center">
                                @if (\Illuminate\Support\Str::length($folder->name) > 30)
                                    {{ \Illuminate\Support\Str::limit($folder->name, 35) }}
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
                                <li style="border-top: solid 1px white">
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

                    <div class="p-2 border-0 rounded bg-white grid w-40 h-32 overflow-hidden click-droit-file bg-cover bg-center group hover:scale-105 transition"
                        data-dropdown-id="dropdownRight-{{ $file->id }}"
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
                                    <span>
                                        👁️
                                    </span>
                                @elseif ($filePermission === 'E')
                                    <span>
                                        ✏️
                                    </span>
                                @elseif ($filePermission === 'LE')
                                    <span>
                                        📝
                                    </span>
                                @else
                                    <span>
                                        🚫
                                    </span>
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
                                <span role="status" wire:loading>
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
                                <span><button class="text-black hover:text-gray-300"> ⋮ </button></span>
                            </div>
                            <div class="text-gray-600 text-sm font-semibold text-center bg-white px-4">
                                <small class="text-xs">
                                    @if (\Illuminate\Support\Str::length($file->nom) > 30)
                                        {{ \Illuminate\Support\Str::limit($file->nom, 30) }}.{{ $type }}
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
                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z"
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
                                    <li class="">
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
                                                </span><span></span>
                                                <svg class="w-4 h-4 text-white dark:text-white hover:text-white "
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                </svg>
                                            </button>
                                        </small> <small>
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
            </div>
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
                    Swal.fire({
                        title: 'Confirmer la suppression',
                        text: "Ce dossier sera supprimé définitivement.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (doc == 'file') {
                                @this.deleteFile(folderId);
                            }
                            if (doc == 'folder') {
                                @this.deleteFolder(folderId)
                            }
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


    })
</script>

<script>
    function supressionMultiple() {
        document.addEventListener('DOMContentLoaded', () => {

            function updateDeleteBar() {
                const checkboxes = document.querySelectorAll('.checkbox-item');
                const checked = Array.from(checkboxes).filter(cb => cb.checked);
                const count = checked.length;

                const bar = document.getElementById('bulk-delete-bar');
                const countSpan = document.getElementById('selected-count');

                if (count > 0) {
                    bar.classList.remove('hidden');
                } else {
                    bar.classList.add('hidden');
                }

                if (countSpan) countSpan.textContent = count;
            }

            function initLongPressSelection() {
                document.querySelectorAll('.click-right, .click-droit-file').forEach((el) => {
                    let timer = null;

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
                if (!deleteButton) return;

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

                if (selectAllBtn) {
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

                if (deselectAllBtn) {
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
                cb.addEventListener('change', updateDeleteBar);
            });
        });
    }

    supressionMultiple();

    // Réinitialisation après re-render Livewire
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
