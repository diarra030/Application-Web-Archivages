<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            @if (Auth::user()->role->nom === 'SuperAdministrateur')
                <div class="text-center">
                    <button
                        class="hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-2 py-2 dark:bg-gray-200 dark:hover:bg-gray-300 focus:outline-none dark:focus:ring-gray-200"
                        type="button" data-drawer-target="drawer-disable-body-scrolling"
                        data-drawer-show="drawer-disable-body-scrolling" data-drawer-body-scrolling="false"
                        aria-controls="drawer-disable-body-scrolling">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="M5 7h14M5 12h14M5 17h14" />
                        </svg>
                    </button>
                </div>
            @endif
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Administrateur') }}
            </h2>
        </div>
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

    @livewire('user', ['users' => $users, 'users_tag' => $users_tag, 'services' => $services, 'documents' => $documents, 'roles' => $roles])

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
        <p>Nos contacts <a href="https://www.dctc-ci.com/" class="text-gray-400 hover:underline hover:text-gray-200">dctc-ci.com</a> - <a class="text-gray-400 hover:underline hover:text-gray-200">info@dctc-ci.com</a> </p>
    </footer>

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
