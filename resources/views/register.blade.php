<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('img/5-1.png') }}" alt="logo" class=" w-40 h-40 mx-auto">
            </a>
        </x-slot>

        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Créer un compte</h2>
        <form action="{{ route('user.new') }}" method="POST">
            @csrf
            <div class="grid gap-6 mb-6 sm:grid-cols-2">
                <!-- Nom -->
                <div class="col-span-2 sm:col-span-1">
                    <label for="name"
                        class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Entrez votre nom" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-span-2 sm:col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Adresse
                        email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="exemple@gmail.com" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="col-span-2">
                    <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Mot de
                        passe</label>
                    <input type="password" name="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Entrez un mot de passe" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Service -->
                <div class="col-span-2 sm:col-span-1">
                    <label for="service"
                        class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Service</label>
                    <select name="service" id="service"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option disabled selected>Choisissez un service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" {{ old('service') == $service->id ? 'selected' : '' }}>
                                {{ $service->nom }}</option>
                        @endforeach
                    </select>
                    @error('service')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rôle -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Choisissez un
                        rôle</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach ($roles as $role)
                            <label class="flex items-center space-x-3">
                                <input type="radio" name="role" value="{{ $role->id }}"
                                    class="text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:bg-gray-600 dark:border-gray-500"
                                    {{ old('role') == $role->id ? 'checked' : '' }}>
                                <span
                                    class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->nom }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Lien de connexion et bouton -->
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-blue-700 hover:underline dark:text-blue-400">Déjà un
                    compte ?</a>
                <button type="submit"
                    class="mt-4 sm:mt-0 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-600">
                    S'enregistrer
                </button>
            </div>
        </form>

    </x-authentication-card>
</x-guest-layout>
