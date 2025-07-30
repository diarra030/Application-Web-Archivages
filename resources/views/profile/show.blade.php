<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Profile') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Gérez vos informations personnelles et paramètres de sécurité.
            </p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-800 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Update Profile Information -->
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Mettre à jour les informations du profil') }}
                    </h3>
                    @livewire('profile.update-profile-information-form')
                </div>
            @endif

            <!-- Update Password -->
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Changer le mot de passe') }}
                    </h3>
                    @livewire('profile.update-password-form')
                </div>
            @endif

            <!-- Two Factor Authentication -->
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Authentification à deux facteurs') }}
                    </h3>
                    @livewire('profile.two-factor-authentication-form')
                </div>
            @endif

            <!-- Logout Other Browser Sessions -->
            <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Déconnecter les autres sessions de navigateur') }}
                </h3>
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            <!-- Delete Account -->
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Supprimer le compte') }}
                    </h3>
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
