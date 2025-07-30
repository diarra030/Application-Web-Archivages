<div>

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

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-4">
                <h3 class="text-lg font-semibold mb-4">Détails du Service</h3>

                <ul class="list-disc pl-5 space-y-4">
                    <li class="flex items-center space-x-4">
                        <strong>Nom :</strong> {{ $service->nom }}
                    </li>
                    <li class="flex items-center space-x-4">
                        <strong>Nombre de documents :</strong> {{ count($service->documents) }}
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="showTableDoc" wire:loading.attr="disabled"
                                class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Voir</span>
                        </label>
                        <div wire:loading wire:target="showTableDoc" role="status">
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
                    </li>

                    @if ($showTableDoc)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nom</th>
                                        <th scope="col" class="px-6 py-3">type</th>
                                        <th scope="col" class="px-6 py-3"><span class="sr-only">Retirer</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($service->documents) > 0)
                                        @foreach ($documents as $document)
                                            <tr
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $document->nom }}</th>
                                                <td class="px-6 py-4">{{ $document->type }}</td>
                                                @if ((Auth::user()->role->nom === 'SuperAdministrateur') | (Auth::user()->role->nom === 'Administrateur'))
                                                    <td class="px-6 py-4 text-right">
                                                        <a href="#" onclick="return confirm('Voulez-vous vraiment retirer ce document de ce service ?')"
                                                            wire:click="retirerDocument({{ $document->id }})"
                                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                            Retirer
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-6 py-4">Aucun document trouvé</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div wire:model="paginatedoc" class="mt-4">
                            {{ $documents->links() }}
                        </div>
                        <div wire:loading wire:target="paginatedoc" class="mt-4">
                            <span>Chargement...</span>
                        </div>
                    @endif

                    <li class="flex items-center space-x-4">
                        <strong>Nombre d'employés :</strong> {{ count($service->users) }}
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="showTableUser" wire:loading.attr="disabled"
                                class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Voir</span>
                        </label>
                        <div wire:loading wire:target="showTableUser" role="status">
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
                    </li>

                    @if ($showTableUser)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nom</th>
                                        <th scope="col" class="px-6 py-3"><span class="sr-only">Retirer</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users) > 0)
                                        @foreach ($users as $user)
                                            <tr
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $user->name }}</th>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-6 py-4">Aucun employé trouvé</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div wire:model="paginateuser" class="mt-4">
                            {{ $users->links() }}
                        </div>
                        <div wire:loading wire:target="paginateuser" class="mt-4">
                            <span>Chargement...</span>
                        </div>
                    @endif
                    
                    {{--
                    <li class="flex items-center space-x-4">
                        <strong>Nombre d'utilisateur identifié :</strong> {{ count($service->identificate) }}
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="showTableUserIdent" wire:loading.attr="disabled"
                                class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Voir</span>
                        </label>
                        <div wire:loading wire:target="showTableUserIdent" role="status">
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
                    </li>

                    @if ($showTableUserIdent)
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Nom</th>
                                        <th scope="col" class="px-6 py-3"><span class="sr-only">Retirer</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($usersIdent) > 0)
                                        @foreach ($usersIdent as $user)
                                            <tr
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $user->name }}</th>
                                                @if ((Auth::user()->role->nom === 'SuperAdministrateur') | (Auth::user()->role->nom === 'Administrateur'))
                                                    <td class="px-6 py-4 text-right">
                                                        <a href="#" onclick="return confirm('Voulez-vous vraiment retirer ce utilisateur de ce service ?')"
                                                            wire:click="retirerDocument({{ $user->id }})"
                                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                            Retirer
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-6 py-4">Aucun utilisateur Identifié</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div wire:model="paginateuserident" class="mt-4">
                            {{ $users->links() }}
                        </div>
                        <div wire:loading wire:target="paginateuserident" class="mt-4">
                            <span>Chargement...</span>
                        </div>
                    @endif
                    --}}

                </ul>


                @if (Auth::user()->role->nom === 'SuperAdministrateur')
                    <div class="space-y-4">
                        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" type="button"
                            class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                            <span
                                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Modifier le service
                            </span>
                        </button>
                        <form action="{{ route('service.destroy', $service->id) }}" method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer ce service ?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                <span
                                    class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    Supprimer le service
                                </span>
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Main modal -->
                {{-- Modal modifier un service --}}
                <div id="crud-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Modifier le nom du service
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="crud-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Fermer modal</span>
                                </button>
                            </div>
                            <form action="{{ route('service.update', $service->id) }}" method="POST"
                                class="p-4 md:p-5">
                                @csrf
                                @method('PUT')
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $service->nom) }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Nom du service" required="">
                                    </div>
                                </div>
                                @if ($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                @endif
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Enregistrer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Main modal -->
                {{-- Modal indentifier un utilisateur --}}
                {{--
                <div id="crud-modal-identifier" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Identifier un ou plusieurs utilisateurs
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="crud-modal-identifier">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Fermer modal</span>
                                </button>
                            </div>
                            <!-- Champ de sélection des utilisateurs -->
                            <div class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label for="user-input"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ciblez des utilisateurs
                                </label>
                                <form action="{{ route('service.ident', $service->id) }}" method="POST">
                                    @csrf
                                    <div class="relative">
                                        <!-- Champ d'entrée -->
                                        <input id="user-input" type="text" name="user-input"
                                            class="block w-full p-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Tapez # pour identifier un ou plusieurs utilisateur(s)" />
                                        <!-- Liste déroulante d'utilisateurs -->
                                        <ul id="user-dropdown"
                                            class="absolute hidden overflow-y-auto max-h-48 z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg dark:bg-gray-700 dark:border-gray-600">
                                            <!-- Utilisateurs ajoutés dynamiquement ici -->
                                        </ul>
                                    </div>
                                    <button type="submit"
                                        class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Valider
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                --}}

            </div>
        </div>
    </div>

    <div class="py-6, px-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Section des 5 derniers documents -->
            <h2 class="text-lg font-bold mb-4"> Activité récente</h2>
            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                @if (count($recentDocuments) > 0)
                    @foreach ($recentDocuments as $document)
                        <li class="pb-3 sm:pb-4">
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $document->nom }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        Ajouté par {{ $document->user->name }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    - {{ $document->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <p> Aucun document ajouté recement </p>
                @endif

            </ul>
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

    <script>
        // Liste simulée des utilisateurs (vous pouvez remplacer par une API ou une base de données)
        var usersArray = @json($allusers);
        const users = usersArray.map(user => user.email);

        // Récupérer les éléments HTML
        const userInput = document.getElementById("user-input");
        const userDropdown = document.getElementById("user-dropdown");

        // Fonction pour afficher les suggestions
        const showSuggestions = (query) => {
            // Filtrer les utilisateurs par le texte saisi
            const matches = users.filter(user => user.toLowerCase().includes(query.toLowerCase()));

            // Vider les options précédentes
            userDropdown.innerHTML = "";

            // Si aucune correspondance, cacher la liste
            if (matches.length === 0) {
                userDropdown.classList.add("hidden");
                return;
            }

            // Afficher les correspondances
            matches.forEach(user => {
                const li = document.createElement("li");
                li.textContent = user;
                li.className = "p-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600";
                li.addEventListener("click", () => {
                    userInput.value += `-${user} `;
                    userDropdown.classList.add("hidden");
                });
                userDropdown.appendChild(li);
            });

            // Afficher la liste déroulante
            userDropdown.classList.remove("hidden");
        };

        // Événement de saisie dans le champ d'entrée
        userInput.addEventListener("input", (e) => {
            const value = e.target.value;
            const lastWord = value.split(" ").pop(); // Dernier mot saisi

            // Vérifier si le dernier mot commence par `#`
            if (lastWord.startsWith("#")) {
                const query = lastWord.slice(1); // Supprimer le `#`
                showSuggestions(query);
            } else {
                userDropdown.classList.add("hidden");
            }
        });

        // Cacher la liste déroulante si on clique à l'extérieur
        document.addEventListener("click", (e) => {
            if (!userDropdown.contains(e.target) && e.target !== userInput) {
                userDropdown.classList.add("hidden");
            }
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

</div>
