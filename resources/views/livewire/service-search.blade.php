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
        <div class="max-w-md mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input id="dropdownNotificationButton" wire:model.live="query" type="search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Rechercher un service" required />
                <div wire:loading wire:target="query" role="status" style="position:absolute; top:15px; right:40px">
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
        </div>

    </div>

    @if ($query)
        <div id="result"
            class=" overflow-y-scroll h-60 max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">

            <h2 class="text-xl font-bold mb-4 text-gray-700 space-x-2">Resultats de la recherche :
                {{ count($services) }}</h2>
            <ul class="divide-y divide-gray-200">
                @if (count($services) > 0)
                    @if (Auth::user()->role->nom == 'SuperAdministrateur')
                    @foreach ($services as $service)
                    <a href="{{ route('show_docs', $service) }}">
                        <button
                            class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex space-x-2">
                            <span>
                                <svg class="w-6 h-6 text-yellow-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </span>
                            <p>{{ $service->nom }}</p>
                        </button>
                    </a>
                    @endforeach
                    @else
                    @foreach ($services as $service)
                        @if (in_array($service->nom, $services_ident) | $service->id == Auth::user()->service->id)
                        <a href="{{ route('show_docs', $service) }}">
                            <button
                                class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex space-x-2">
                                <span>
                                    <svg class="w-6 h-6 text-yellow-500 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                            clip-rule="evenodd" />
                                    </svg>

                                </span>
                                <p>{{ $service->nom }}</p>
                            </button>
                        </a>
                        @else
                        <button
                            class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex space-x-2">
                            <span>
                                <svg class="w-6 h-6 text-yellow-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </span>
                            <p class="text-gray-400">{{ $service->nom }}</p>
                        </button>
                        @endif
                    @endforeach
                    @endif
                @else
                    <li class="py-3 text-gray-600"> Aucun resultat </li>
                @endif
            </ul>
        </div>
    @endif
</div>
