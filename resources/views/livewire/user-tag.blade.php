<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    <div>
        {{-- The best athlete wants his opponent at his best. --}}

        <div>
            <label for="user-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Ciblez des utilisateurs
            </label>
            <div class="relative mt-2">
                <!-- Champ d'entrée -->
                <input id="user-input" type="text" wire:model.debounce.300ms="query"
                    placeholder="Tapez # pour identifier un ou plusieurs utilisateur(s)"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-600 dark:text-white" />

                @if ($errors->has('user-input'))
                    <span class="text-red-500 text-sm">{{ $errors->first('user-input') }}</span>
                @endif

                <!-- Liste déroulante des utilisateurs -->
                @if (!empty($users))
                    <ul
                        class="absolute z-10 w-full mt-2 bg-white border border-gray-300 rounded-md shadow-lg max-h-48 overflow-y-auto dark:bg-gray-700 dark:border-gray-600">
                        @foreach ($users as $user)
                            <li wire:click="selectUser({{ $user['id'] }})"
                                class="px-4 py-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                                {{ $user['name'] }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <!-- Utilisateurs sélectionnés -->
            @if (!empty($selectedUsers))
                <div class="mt-4">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Utilisateurs sélectionnés :</h3>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($selectedUsers as $user)
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-700">
                                {{ $user['name'] }}
                                <button wire:click="removeUser({{ $user['id'] }})" type="button"
                                    class="ml-2 text-white focus:outline-none">
                                    &times;
                                </button>
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>

</div>
