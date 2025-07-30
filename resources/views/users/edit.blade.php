<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('user') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z" clip-rule="evenodd"/>
                        </svg>
                        Administrateur
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Modifier utilisateur</span>
                    </div>
                </li>
            </ol>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-4 md:p-5">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800 dark:text-white">
            Modification de l'utilisateur {{ $user->name }}
        </h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2">
        <!-- Champ nom -->
        <div class="col-span-2">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   placeholder="Nom de l'utilisateur" required>
            @if ($errors->has('name'))
                <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <!-- Champ email -->
        <div class="col-span-2">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   placeholder="exemple@gmail.com" required>
            @if ($errors->has('email'))
                <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <!-- Champ service -->
        <div class="col-span-2">
            <label for="service" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Service</label>
            <select id="service" name="service"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                @foreach($services as $service)
                    <option value="{{ $service->id }}"
                        @if($user->service->id == $service->id) selected @endif>
                        {{ $service->nom }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('service'))
                <span class="text-red-500 text-sm">{{ $errors->first('service') }}</span>
            @endif
        </div>

        <!-- Champ mot de passe -->
        <div class="col-span-2 md:col-span-1">
    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nouveau mot de passe</label>
    <input type="password" name="password" id="password"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
           placeholder="••••••••••••••••••••••••••••••••••••••••••••••••••••••••">
    @if ($errors->has('password'))
        <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
    @endif
</div>

<div class="col-span-2 md:col-span-1">
    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmation du mot de passe</label>
    <input type="password" name="password_confirmation" id="password_confirmation"
           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
           placeholder="Confirmez le mot de passe">
</div>


        <!-- Champ rôle -->
        <div class="col-span-2">
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choisissez un rôle</label>
            <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @foreach($roles as $role)
                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                        <div class="flex items-center px-3">
                            <input id="role{{ $role->id }}" type="radio" value="{{ $role->id }}" name="role"
                                   @if($user->role_id == $role->id) checked @endif
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="role{{ $role->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $role->nom }}</label>
                        </div>
                    </li>
                @endforeach
            </ul>
            @if ($errors->has('role'))
                <span class="text-red-500 text-sm">{{ $errors->first('role') }}</span>
            @endif
        </div>
    </div>

    <div class="flex justify-center">
        <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Mettre à jour les données utilisateur
        </button>
    </div>
</form>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 text-center py-6 w-full">
        <p>&copy; 2025 DCTC-eDoc - Tous droits réservés.</p>
        <p>Nos contacts <a href="https://www.dctc-ci.com/" class="text-gray-400 hover:underline hover:text-gray-200">dctc-ci.com</a> - <a class="text-gray-400 hover:underline hover:text-gray-200">info@dctc-ci.com</a> </p>
    </footer>

</x-app-layout>
