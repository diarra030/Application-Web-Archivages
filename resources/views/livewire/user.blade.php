<div>

    {{-- Components --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray overflow-hidden shadow-xl sm:rounded-lg flex items-center space-x-4 p-4">
                <p class="text-lg font-medium text-gray-900 dark:text-white flex-auto">Bienvenue administrateur</p>
                <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                    <a href="#" class="w-11/12 sm:w-1/2 md:w-1/3 h-28 p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 flex flex-col justify-center items-center">
                        <h5 class="text-base font-semibold tracking-tight text-gray-900 dark:text-white">Nombre de documents archivés</h5>
                        <p class="text-sm font-normal text-gray-700 dark:text-gray-400">{{ count($documents) }}</p>
                    </a>

                    <a href="#" class="w-11/12 sm:w-1/2 md:w-1/3 h-28 p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 flex flex-col justify-center items-center">
                        <h5 class="text-base font-semibold tracking-tight text-gray-900 dark:text-white">Nombre d'utilisateurs</h5>
                        <p class="text-sm font-normal text-gray-700 dark:text-gray-400">{{ count($users) }}</p>
                    </a>

                    <a href="#" class="w-11/12 sm:w-1/2 md:w-1/3 h-28 p-3 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 flex flex-col justify-center items-center">
                        <h5 class="text-base font-semibold tracking-tight text-gray-900 dark:text-white">Nombre de services</h5>
                        <p class="text-sm font-normal text-gray-700 dark:text-gray-400">{{ count($services) }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pr-8 pl-8 pt-5 pb-5">
                {{-- Tableau --}}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-5 pb-5">
                    <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">

                        <!-- Champ de recherche -->
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rechercher un utilisateur">
                        </div>
                    </div>

                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nom de l'utilisateur</th>
                            <th scope="col" class="px-6 py-3">Service</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            @if (Auth::user()->role->nom === "SuperAdministrateur")
                            <th scope="col" class="px-6 py-3 rounded-e-lg">
                                Actions
                            </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody id="user-table">
                        @foreach($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $user->name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $user->service->nom }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role)
                                        {{ $user->role->nom }}
                                    @else
                                        Aucun role
                                    @endif
                                </td>
                                @if (Auth::user()->role->nom === "SuperAdministrateur")
                                <td class="px-6 py-4">
                                    <a href="{{ route('users.edit', $user->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        modifier
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Menu --}}
    <div class="py-12 pr-3 pl-3">

        <!-- drawer component -->
        <div id="drawer-disable-body-scrolling" class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-64 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-disable-body-scrolling-label">
            <h5 id="drawer-disable-body-scrolling-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>
            <button type="button" data-drawer-hide="drawer-disable-body-scrolling" aria-controls="drawer-disable-body-scrolling" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <div class="py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">

                    {{-- Creer un utilisateur --}}
                    <li>
                        <a data-modal-target="crud-modal" data-modal-toggle="crud-modal" href="#" class="flex items-center p-2 text-blue-900 rounded-lg dark:text-white hover:bg-blue-200 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-blue-500 transition duration-75 group-hover:text-blue-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                                <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Creer un utilisateur</span>
                        </a>
                    </li>
                    {{-- Fin Creer un utilisateur --}}

                    <hr class="h-1.5">

                    {{-- Gestion des services--}}
                    <li>
                        <a href=" {{ route("service")  }}" class="flex items-center p-2 text-yellow-900 rounded-lg dark:text-white hover:bg-yellow-200 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-yellow-500 transition duration-75 dark:text-yellow-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Gestion des services</span>
                        </a>
                    </li>
                    {{-- Fin Gestion des services --}}

                </ul>
            </div>
        </div>
    </div>

    {{-- Gestion user modal --}}
    {{-- Modal creer user --}}
    <!-- Main modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Creer un nouveau utilisateur
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form action="{{ route("user.store")  }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nom de l'utilisateur" required="">
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
                        @endif
                        <div class="col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="exemple@gmail.com" required="">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                        @endif
                        <div class="col-span-2">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de passe</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
                        @endif
                        <div class="col-span-2 sm:col-span-1">
                            <label for="service" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service</label>
                            <select id="service" name="service" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Selectionnez un service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service') == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('service'))
                            <span class="text-red-500 text-sm">{{ $errors->first('service') }}</span>
                        @endif
                        <div class="col-span-2">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisissez un rôle</label>
                            <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach($roles as $role)
                                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                        <div class="flex items-center ps-3">
                                            <input id="role" type="radio" value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }} name="role" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="role" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $role->nom }} </label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @if ($errors->has('role'))
                            <span class="text-red-500 text-sm">{{ $errors->first('role') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Ajoutez l'utilisateur
                    </button>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Fonction de recherche
        document.getElementById('table-search').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let rows = document.querySelectorAll('#user-table tr');

            rows.forEach(row => {
                let name = row.querySelector('th').textContent.toLowerCase();
                let service = row.querySelectorAll('td')[0].textContent.toLowerCase();
                let role = row.querySelectorAll('td')[1].textContent.toLowerCase();

                if (name.includes(searchText) || service.includes(searchText) || role.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</div>
