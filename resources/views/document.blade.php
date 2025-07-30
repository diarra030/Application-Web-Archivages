<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Classeurs') }}
            </h2>
        </div>
        @livewire('service-search')

    </x-slot>

    <style>
        #toast-success {
            position: fixed;
            top: 10%;
            /* Position relative à la hauteur de l'écran */
            right: 5%;
            /* Position relative à la largeur de l'écran */
            z-index: 100;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1rem;
            /* Utilisation d'unités relatives */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            max-width: 90%;
            /* Limite la largeur pour les petits écrans */
            font-size: 1rem;
            /* Taille de police relative */
        }

        .grossirDrag {
            
            background-color: rgba(175, 164, 164, 0.6);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 482.14 482.14"><g><path d="M302.599,0H108.966C80.66,0,57.652,23.025,57.652,51.315v379.509c0,28.289,23.008,51.315,51.314,51.315h264.205 c28.275,0,51.316-23.026,51.316-51.315V121.449L302.599,0z M373.171,450.698H108.966c-10.969,0-19.89-8.905-19.89-19.874V51.315 c0-10.953,8.921-19.858,19.89-19.858l181.875-0.189v67.218c0,19.653,15.949,35.603,35.588,35.603l65.877-0.189l0.725,296.925 C393.03,441.793,384.142,450.698,373.171,450.698z"/><path d="M241.054,150.96c-49.756,0-90.102,40.347-90.102,90.109c0,49.764,40.346,90.11,90.102,90.11 c49.771,0,90.117-40.347,90.117-90.11C331.171,191.307,290.825,150.96,241.054,150.96z M273.915,253.087h-20.838v20.835 c0,6.636-5.373,12.017-12.023,12.017c-6.619,0-12.01-5.382-12.01-12.017v-20.835H208.21c-6.637,0-12.012-5.383-12.012-12.018 c0-6.634,5.375-12.017,12.012-12.017h20.834v-20.835c0-6.636,5.391-12.018,12.01-12.018c6.65,0,12.023,5.382,12.023,12.018v20.835 h20.838c6.635,0,12.008,5.383,12.008,12.017C285.923,247.704,280.55,253.087,273.915,253.087z"/></g></svg>');
            background-repeat: no-repeat;
            background-size: 50px 50px; /* ou cover selon besoin */
            background-position: center;
            z-index: 1;
        }
        .grossirDrag * {
         opacity: 0.5; /* Rend les éléments enfants transparents */
        }



        /* Media query pour les écrans plus grands */
        @media (min-width: 768px) {
            #toast-success {
                top: 50px;
                /* Fixé pour les écrans moyens à larges */
                right: 20px;
                max-width: 300px;
                /* Réduit la largeur pour un affichage plus élégant */
                padding: 1rem;
                font-size: 1rem;
            }
        }

        /* Media query pour les très grands écrans */
        @media (min-width: 1200px) {
            #toast-success {
                right: 50px;
                /* Décalé davantage à droite */
                top: 50px;
            }
        }
    </style>

    <div class="flex  relative mx-auto" style="height:80vh;">
        <!-- Contenu principal -->
        <main class="flex-1 p-6 bg-gray-100 dark:bg-gray-900">
            <!-- Liste de dossiers -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 ">
                @if (count($documentGene) > 0)
                    <div>
                        <button
                            class="flex flex-col items-center w-full p-4 bg-white rounded-lg shadow hover:shadow-md transition">
                            <a href="{{ route('show_docs', 0) }}">
                                <img src="{{ asset('img/depot.svg') }}" style="height: 100px" alt="">
                                <span class="mt-2 text-sm font-medium text-gray-700">Depôts</span>
                            </a>
                        </button>
                    </div>
                @endif
                @if ((Auth::user()->role->nom == 'SuperAdministrateur') | (Auth::user()->role->nom == 'Administrateur'))
                    @foreach ($servicePaginate as $service)
                        <div>
                            <button 
                                class="iconButton flex flex-col items-center w-full p-4 bg-white rounded-lg shadow hover:shadow-md transition"
                                data-service-id="{{ $service->id }}"
                                >
                                <a href="{{ route('show_docs', $service->id) }}">
                                    <img src="{{ asset('img/classeur.svg') }}" style="height: 100px" alt="">
                                    <span class="mt-2 text-sm font-medium text-gray-700">{{ $service->nom }} </span>
                                </a>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div>
                        <button
                            class="flex flex-col items-center w-full p-4 bg-white rounded-lg shadow hover:shadow-md transition">
                            <a href="{{ route('show_docs', $service->id) }}">
                                <img src="{{ asset('img/classeur.svg') }}" style="height: 100px" alt="">
                                <span class="mt-2 text-sm font-medium text-gray-700">{{ $service->nom }}</span>
                            </a>
                        </button>
                    </div>
                    @foreach ($serviceIdent as $serv)
                        <div>
                            <button
                                class="flex flex-col items-center w-full p-4 bg-white rounded-lg shadow hover:shadow-md transition">
                                <a href="{{ route('show_docs', $serv->id) }}">
                                   
                                    <span class="mt-2 text-sm font-medium text-gray-700">{{ $serv->nom }}</span> 
                                </a>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class=" py-4 px-6 rounded-lg  " style="margin-top:30px ">
                {{ $servicePaginate->links()}}
            </div>
        </main>
        
    </div>

    {{-- Menu --}}



    <!-- Main modal -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-scroll overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                @livewire('uploadingfile', ['services' => $services])
            </div>
        </div>
    </div>

    <!-- Modal Supprimer -->
    <div id="extralarge-modal" data-modal-backdrop="static" tabindex="-1"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-7xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                        Supprimer documents
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="extralarge-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">

                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pr-8 pl-8 pt-5 pb-5">
                                {{-- Tableau --}}
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5 pb-5">
                                    <div
                                        class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">

                                        <div class="p-2 inline-flex">
                                            <!-- Champ de recherche -->
                                            <label for="table-search" class="sr-only">Search</label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                        aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <input type="text" id="table-search"
                                                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="Rechercher un document">
                                            </div>
                                        </div>
                                        <div class="p-2 justify-items-start">
                                            Total documents : {{ $totalDocuments }}
                                        </div>

                                    </div>
                                    <livewire:folder-manager />
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 inline-flex space-x-2">
                                                    Nom du document
                                                </th>
                                                <th scope="col" class="px-6 py-3">Type</th>
                                                <th scope="col" class="px-6 py-3">Service</th>
                                                <th scope="col" class="px-6 py-3 rounded-e-lg">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="user-table">
                                            @foreach ($documents as $document)
                                                <tr
                                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white inline-flex space-x-2">
                                                        {{ $document->nom }}.{{ $document->type }} hello 
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        @if ($document->type == 'pdf')
                                                            <span>
                                                                <svg class="w-6 h-6 text-red-500 dark:text-red-400"
                                                                    aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path fill-rule="evenodd"
                                                                        d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </span>
                                                        @elseif (($document->type == 'docx') | ($document->type == 'doc'))
                                                            <svg class="w-6 h-6 text-blue-800 dark:text-blue"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path
                                                                    d="M6 16v-3h.375a.626.626 0 0 1 .625.626v1.749a.626.626 0 0 1-.626.625H6Zm6-2.5a.5.5 0 1 1 1 0v2a.5.5 0 0 1-1 0v-2Z" />
                                                                <path fill-rule="evenodd"
                                                                    d="M11 7V2h7a2 2 0 0 1 2 2v5h1a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2H3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h6a2 2 0 0 0 2-2Zm7.683 6.006 1.335-.024-.037-2-1.327.024a2.647 2.647 0 0 0-2.636 2.647v1.706a2.647 2.647 0 0 0 2.647 2.647H20v-2h-1.335a.647.647 0 0 1-.647-.647v-1.706a.647.647 0 0 1 .647-.647h.018ZM5 11a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 9 15.375v-1.75A2.626 2.626 0 0 0 6.375 11H5Zm7.5 0a2.5 2.5 0 0 0-2.5 2.5v2a2.5 2.5 0 0 0 5 0v-2a2.5 2.5 0 0 0-2.5-2.5Z"
                                                                    clip-rule="evenodd" />
                                                                <path
                                                                    d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                                                            </svg>
                                                        @elseif (($document->type == 'xlsx') | ($document->type == 'xls'))
                                                            <svg class="w-6 h-6 text-green-800 dark:text-green"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif (($document->type == 'pptx') | ($document->type == 'ppt'))
                                                            <svg class="w-6 h-6 text-orange-800 dark:text-red"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H11Zm1.5 3H12v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 1 0 0 2v4a1 1 0 1 0 2 0v-4a1 1 0 1 0 0-2h-2Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif ($document->type == 'csv')
                                                            <svg class="w-6 h-6 text-green-800 dark:text-green"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif (($document->type == 'png') | ($document->type == 'jpeg'))
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm.394 9.553a1 1 0 0 0-1.817.062l-2.5 6A1 1 0 0 0 8 19h8a1 1 0 0 0 .894-1.447l-2-4A1 1 0 0 0 13.2 13.4l-.53.706-1.276-2.553ZM13 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @elseif ($document->type == 'txt')
                                                            <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @if (count($document->services) > 0)
                                                            @foreach ($document['services'] as $service)
                                                                {{ $service->nom }}
                                                            @endforeach
                                                        @else
                                                            Aucun service
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <form action="{{ route('documents.destroy', $document->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Voulez-vous vraiment terminer cette action ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" href="#"
                                                                class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                                Supprimer
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('success'))
        <div id="toast-success"
            class="flex items-center w-full max-w-xs p-4 mt-6 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @elseif (session('error'))
        <div id="toast-success"
            class="flex items-center w-full max-w-xs p-4 mt-6 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('error') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 text-center py-6 w-full">
        <p>&copy; 2025 DCTC-eDoc - Tous droits réservés.</p>
        <p>Nos contacts <a href="https://www.dctc-ci.com/"
                class="text-gray-400 hover:underline hover:text-gray-200">dctc-ci.com</a> - <a
                class="text-gray-400 hover:underline hover:text-gray-200">info@dctc-ci.com</a> </p>
    </footer>

    <script>
        // Fonction de recherche
        document.getElementById('table-search').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let rows = document.querySelectorAll('#user-table tr');

            rows.forEach(row => {
                let name = row.querySelector('th').textContent.toLowerCase();
                let type = row.querySelectorAll('td')[0].textContent.toLowerCase();
                let service = row.querySelectorAll('td')[1].textContent.toLowerCase();

                if (name.includes(searchText) || type.includes(searchText) || service.includes(
                        searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <script>
        // Cache le toast après 5 secondes
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.remove();
            }
        }, 5000); // 10000ms = 10 secondes
    </script>

 <!--script qui prend en charge le drag & drop sur un dossier ou service   -->
<script>
            // Sélectionne toutes les divs avec la classe .iconFile
        const dropzoneService = document.querySelectorAll('.iconButton');
        const openModalDoc= document.querySelector('.openModalDoc');
        let fileTotal;

        // Fonction pour empêcher le comportement par défaut
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Gestion des événements pour chaque élément
        dropzoneService.forEach(element => {
            ['dragover', 'dragleave', 'drop'].forEach(event => {
                element.addEventListener(event, preventDefaults);
            });

            element.addEventListener('dragover', () => {
                element.classList.add("grossirDrag");
            });

            element.addEventListener('dragleave', () => {
                element.classList.remove("grossirDrag");
            });

            
            

            element.addEventListener('drop', (e) => {
                element.classList.remove("grossirDrag");
                //obtenir le id de service apres un drop
                let serviceId = element.getAttribute('data-service-id'); // Récupère l'ID
                openModalDoc.click()
                e.preventDefault();
                let checkbox = document.querySelector(`#service-checkbox-${serviceId}`);
                if (checkbox) {
                    
                    checkbox.click() // Ajoute l'attribut checked  
                    
                }
                
                
                const dt = e.dataTransfer;
                const files = dt.files;

            if (files.length) {
                    // Simule un "drop" sur `.dropzone`
            if (dropzone) {
            [...files].forEach(file => {
                
                const dropEvent = new DragEvent("drop", {
                    bubbles: true,
                    cancelable: true,
                    dataTransfer: new DataTransfer()
                });
                dropEvent.dataTransfer.items.add(file);
                dropzone.dispatchEvent(dropEvent);
            });
            fileTotal=files.length
            
        } else {
            console.error("Aucune dropzone trouvée.");
        }
                }
            });
        });

</script>

</x-app-layout>
