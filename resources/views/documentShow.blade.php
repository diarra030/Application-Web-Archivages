<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('document') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 5a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L15.249 6H19a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v-5a3 3 0 0 0-3-3h-3.22l-1.14-1.682A3 3 0 0 0 9.157 6H6V5Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 9a2 2 0 0 1 2-2h4.157a2 2 0 0 1 1.656.879L12.249 10H3V9Zm0 3v7a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-7H3Z"
                                clip-rule="evenodd" />
                        </svg>
                        Document
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        @if (!empty($service))
                            <span
                                class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ __('Service ') . $service->nom }}</span>
                        @else
                            <span
                                class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Depôts</span>
                        @endif
                    </div>
                </li>
            </ol>
        </div>
        @if (!empty($service))
            @livewire('document-search', ['service' => $service])
        @else
            @livewire('document-search', ['service' => null])
        @endif

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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!empty($service))
                @if ((Auth::user()->role->nom == 'SuperAdministrateur') | (Auth::user()->role->nom == 'Administrateur'))
                    <button data-modal-target="static-modal-doc" data-modal-toggle="static-modal-doc" type="button"
                        class=" inline-flex space-x-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>
                        <span>Ajouter un document</span>
                    </button>
                @endif
            @endif
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pr-8 pl-8 pt-5 pb-5">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5 pb-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class=" bg-blue-600 text-white text-xs dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 rounded-s-lg">Nom</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                                <th scope="col" class="px-6 py-3">Taille</th>
                                <th scope="col" class="px-6 py-3">Date d'ajout</th>
                                <th scope="col" class="px-6 py-3 rounded-e-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="documents-list" class="divide-y divide-gray-200">
                            @if (count($documents) > 0)
                                @foreach ($documents as $document)
                                    <tr
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $document->nom }}</td>
                                        <td class="px-6 py-4">
                                            @if ($document->type == 'pdf')
                                                <span>
                                                    <svg class="w-6 h-6 text-red-500 dark:text-red-400"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @elseif (($document->type == 'docx') | ($document->type == 'doc'))
                                                <span>
                                                    <svg class="w-6 h-6 text-blue-800 dark:text-blue" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M6 16v-3h.375a.626.626 0 0 1 .625.626v1.749a.626.626 0 0 1-.626.625H6Zm6-2.5a.5.5 0 1 1 1 0v2a.5.5 0 0 1-1 0v-2Z" />
                                                        <path fill-rule="evenodd"
                                                            d="M11 7V2h7a2 2 0 0 1 2 2v5h1a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-1a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2H3a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h6a2 2 0 0 0 2-2Zm7.683 6.006 1.335-.024-.037-2-1.327.024a2.647 2.647 0 0 0-2.636 2.647v1.706a2.647 2.647 0 0 0 2.647 2.647H20v-2h-1.335a.647.647 0 0 1-.647-.647v-1.706a.647.647 0 0 1 .647-.647h.018ZM5 11a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 9 15.375v-1.75A2.626 2.626 0 0 0 6.375 11H5Zm7.5 0a2.5 2.5 0 0 0-2.5 2.5v2a2.5 2.5 0 0 0 5 0v-2a2.5 2.5 0 0 0-2.5-2.5Z"
                                                            clip-rule="evenodd" />
                                                        <path
                                                            d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                                                    </svg>
                                                </span>
                                            @elseif (($document->type == 'xlsx') | ($document->type == 'xls'))
                                                <span>
                                                    <svg class="w-6 h-6 text-green-800 dark:text-green"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @elseif (($document->type == 'pptx') | ($document->type == 'ppt'))
                                                <span>
                                                    <svg class="w-6 h-6 text-orange-800 dark:text-red"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H11Zm1.5 3H12v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 1 0 0 2v4a1 1 0 1 0 2 0v-4a1 1 0 1 0 0-2h-2Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @elseif ($document->type == 'csv')
                                                <span>
                                                    <svg class="w-6 h-6 text-green-800 dark:text-green"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @elseif (($document->type == 'png') | ($document->type == 'jpeg'))
                                                <span>
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm.394 9.553a1 1 0 0 0-1.817.062l-2.5 6A1 1 0 0 0 8 19h8a1 1 0 0 0 .894-1.447l-2-4A1 1 0 0 0 13.2 13.4l-.53.706-1.276-2.553ZM13 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @elseif ($document->type == 'txt')
                                                <span>
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $document->taille }} ko</td>
                                        <td class="px-6 py-4">{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 text-sm space-x-4 inline-flex">
                                            <a href="{{ route('pdf.view', $document->id) }}"
                                                class="text-blue-500 hover:underline">Ouvrir</a>
                                            <a href="#"
                                                onclick="printDocument('{{ asset('storage/' . $document->filename) }}')"
                                                class="text-green-500 hover:underline">
                                                Imprimer
                                            </a>
                                            @if ((Auth::user()->role->nom == 'SuperAdministrateur') | (Auth::user()->role->nom == 'Administrateur'))
                                                <form action="{{ route('documents.destroy', $document->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer ce document ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-500 hover:underline">Supprimer</button>
                                                </form>
                                            @else
                                            @endif
                                            <a data-tooltip-target="tooltip-animation {{ $document->id }}"
                                                href="{{ route('tag', $document->id) }}">
                                                <svg class="w-6 h-6 text-blue-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M3 5.983C3 4.888 3.895 4 5 4h14c1.105 0 2 .888 2 1.983v8.923a1.992 1.992 0 0 1-2 1.983h-6.6l-2.867 2.7c-.955.899-2.533.228-2.533-1.08v-1.62H5c-1.105 0-2-.888-2-1.983V5.983Zm5.706 3.809a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Zm2.585.002a1 1 0 1 1 .003 1.414 1 1 0 0 1-.003-1.414Zm5.415-.002a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <div id="tooltip-animation {{ $document->id }}" role="tooltip"
                                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                Laisser un message
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="hover:bg-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-600">Aucun document trouvé</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $documents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal body ajouter dcument-->
    <!-- Main modal -->
    <div id="static-modal-doc" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-scroll overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                @if (!empty($service))
                    @livewire('add-doc-serv', ['service' => $service])
                @endif
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
        function printDocument(url) {
            const win = window.open(url, '_blank');
            win.print();
        }
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

</x-app-layout>
