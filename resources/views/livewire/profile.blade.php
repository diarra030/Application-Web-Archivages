<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">

                    <!-- Colonne de gauche -->
                    <div class="flex-1 bg-white shadow-md rounded-lg p-6">
                        <style>
                            .avatar-large {
                                width: 150px;
                                height: 150px;
                            }

                            .avatar-large svg {
                                width: 180px;
                                height: 180px;
                                left: -15px;
                            }

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

                        <div class="relative overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 avatar-large">
                            <svg class="absolute text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <h4 class="text-2xl font-bold text-gray-800 mb-4">Informations du compte</h4>

                        @if ($modifier)
                            <form action="{{ route('user.update_profile', Auth::user()->id) }}" method="POST">
                                @csrf
                                @method('PUT')


                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <label for="name" class="font-semibold text-gray-600 w-1/6">Nom</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', Auth::user()->name) }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Nom de l'utilisateur" required="">
                                    </div>
                                    <div class="flex items-center">
                                        <label for="email" class="font-semibold text-gray-600 w-1/6">Adresse
                                            email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', Auth::user()->email) }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Adresse email" required="">
                                    </div>
                                    <div class="flex items-center">
                                        <label for="service" class="font-semibold text-gray-600 w-1/6">Service</label>
                                        <select disabled id="service"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            <option selected>{{ Auth::user()->service->nom }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                                    <button type="submit" wire:loading.attr="btn-enr"
                                        class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg wire:loading wire:target="btn-enr" aria-hidden="true" role="status"
                                            class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="#E5E7EB" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentColor" />
                                        </svg>
                                        Enregistrer
                                    </button>
                                    <button wire:click="close" wire:loading.attr="btn-annul" type="button"
                                        class="w-full sm:w-auto text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                        <svg wire:loading wire:target="btn-annul" aria-hidden="true" role="status"
                                            class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="#E5E7EB" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentColor" />
                                        </svg>
                                        Annuler
                                    </button>

                                </div>
                            </form>
                        @else
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="font-semibold text-gray-600 w-1/6">Nom :</span>
                                    <span class="text-gray-900">{{ Auth::user()->name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="font-semibold text-gray-600 w-1/6">Adresse email :</span>
                                    <span class="text-gray-900">{{ Auth::user()->email }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="font-semibold text-gray-600 w-1/6">Service :</span>
                                    <span class="text-gray-900">{{ Auth::user()->service->nom }}</span>
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col sm:flex-row gap-4">
                                <button wire:click="open" type="button"
                                    class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    <svg wire:loading aria-hidden="true" role="status"
                                        class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="#E5E7EB" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentColor" />
                                    </svg>
                                    Modifier le profil
                                </button>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button href="{{ route('logout') }}" @click.prevent="$root.submit();" type="submit"
                                        class="w-full sm:w-auto text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                        Se déconnecter
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Barre verticale -->
                    <div class="hidden md:block w-px bg-gray-200"></div>

                    <!-- Colonne de droite -->
                    <div class="flex-1 bg-white shadow-md rounded-lg p-6">
                        <h4 class="text-2xl font-bold text-gray-800 mb-4">Changer le mot de passe</h4>

                        <form action="{{ route('user.update_password') }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label for="current_password" class="font-semibold text-gray-600">Mot de passe
                                        actuel</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full mt-1 p-2 border rounded-lg" required>
                                </div>
                                <div>
                                    <label for="new_password" class="font-semibold text-gray-600">Nouveau mot de
                                        passe</label>
                                    <input type="password" name="new_password" id="new_password"
                                        class="w-full mt-1 p-2 border rounded-lg" required>
                                </div>
                                <div>
                                    <label for="confirm_password" class="font-semibold text-gray-600">Confirmer le mot
                                        de passe</label>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                        class="w-full mt-1 p-2 border rounded-lg" required>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="sumit"
                                    class="w-full sm:w-auto text-white bg-blue-600 hover:bg-bue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notifications -->
                @if (session('success'))
                    <div id="toast-success"
                        class="flex items-center w-full max-w-xs p-4 mt-6 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
                        role="alert">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                        </div>
                        <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                            data-dismiss-target="#toast-success" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif

                @error('current_password')
                    <div id="toast-success"
                        class="flex items-center w-full max-w-xs p-4 mt-6 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400"
                        role="alert">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                            </svg>
                            <span class="sr-only">Error icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal">{{ $message }}</div>
                        <button type="button"
                            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                            data-dismiss-target="#toast-success" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @enderror
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">

                                <!-- Logout Other Browser Sessions -->
            <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Déconnecter les autres sessions de navigateur') }}
                </h3>
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Cache le toast après 10 secondes
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.remove();
            }
        }, 10000); // 10000ms = 10 secondes
    </script>

</div>
