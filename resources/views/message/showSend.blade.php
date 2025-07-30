<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('message') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5.983C3 4.888 3.895 4 5 4h14c1.105 0 2 .888 2 1.983v8.923a1.992 1.992 0 0 1-2 1.983h-6.6l-2.867 2.7c-.955.899-2.533.228-2.533-1.08v-1.62H5c-1.105 0-2-.888-2-1.983V5.983Zm5.706 3.809a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Zm2.585.002a1 1 0 1 1 .003 1.414 1 1 0 0 1-.003-1.414Zm5.415-.002a1 1 0 1 0-1.412 1.417 1 1 0 1 0 1.412-1.417Z" clip-rule="evenodd"/>
                        </svg>

                        Messages
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ __('Détails du Message') }}</span>
                    </div>
                </li>
            </ol>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="max-w-3xl mx-auto bg-white shadow rounded-lg dark:bg-gray-800 p-6">

            <div class="flex items-center space-x-4">
                <!-- Avatar du tagged -->
                <div
                    class="relative inline-flex items-center justify-center w-12 h-12 overflow-hidden bg-blue-100 rounded-full dark:bg-gray-600">
                    <span class="font-medium text-gray-600 dark:text-gray-300">
                        {{ $tagged->name[0] }}
                    </span>
                </div>

                <!-- Nom et email du tagged -->
                <div>
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        Vous à {{ $tagged->name }}
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        {{ $tagged->email }}
                    </p>
                </div>
            </div>


            <!-- Contenu du message -->
            <div class="mb-4 py-5">
                <p class="text-gray-700 dark:text-gray-300">
                    {{ $pivot->message }}
                </p>
                <p class="text-gray-500 dark:text-gray-300">
                    Document concerné : <span class="text-blue-500">{{ $document->nom }}</span>
                </p>
                <!-- Indicateur de message -->
                @if ($pivot->new == true)
                    <span class="">
                        <em class="font-italic text-xs text-gray-200">Envoyé...</em>
                    </span>
                @else
                    <span class="">
                        <em class="font-italic text-xs text-gray-200">Vu</em>
                    </span>
                @endif
            </div>

            <!-- Date de création -->
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Envoyé le : {{ $pivot->created_at }}
                </p>
            </div>
        </div>

</x-app-layout>
