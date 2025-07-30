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

    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Ajouter un ou plusieurs documents
        </h3>
        <button id="close_button" type="button"  wire:click="removeAll()"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="static-modal-doc">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
    </div>
    <!-- Modal body -->
    <div class="p-6 md:p-8 bg-gray-50 dark:bg-gray-800 shadow-md rounded-lg space-y-6">
        <form wire:submit="save" class="max-w-lg mx-auto space-y-6">
            <!-- File Selection Section -->
            @csrf
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white" for="file_input">
                    Sélectionner un fichier
                </label>
                <div class="flex items-center gap-4">
                    <div class="max-w-lg mx-auto" style="width: 100% ; text-align:center">
                        <!-- Zone de Drag & Drop -->
                        <div id="dropzone"
                            class="border-2 border-dashed rounded-lg p-6 flex flex-col items-center justify-center transition-all border-gray-300 w-full">
                            <input  type="file" id="upload" class="hidden" wire:model.defer="files" multiple>
                            <label for="upload" class="cursor-pointer text-gray-500 hover:text-blue-500">
                                <svg class="w-full h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 16V12m10 4v-4m-5 4V4m-4 4l4-4m0 0l4 4M3 20h18" />
                                </svg>
                                <p class="mt-2">Glissez-déposez un fichier ou un dossier ici<br>ou cliquez pour
                                    sélectionner</p>
                            </label>
                        </div>
                        <!-- Loading Indicator -->
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2 " id="bar-upload-file-progress" style="display: none">
                            <!-- Barre de progression avec Alpine.js -->
                            <div id="progress" class="bg-blue-500 h-2 rounded-full transition-all "
                                style="width: 0%;"></div>
                            <!-- Affichage du pourcentage -->
                            <p id="progressText" class="text-sm text-gray-600 mt-1">0%</p>
                        </div>
                        <div class="flex justify-end w-full">
                            @if ($compteFileSelected>0)
                                <span id="totalFile">{{ count($files) }}/{{ $compteFileSelected }}</span>  
                            @endif
                                <span wire:loading  class="mt-1">
                                    <svg aria-hidden="true"
                                    class="w-4 h-4 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                 </svg>
                                </span>
                        </div> 
                        @if ($files)
                        <div class="overflow-y-auto h-30 border rounded-lg bg-gray-50 mt-4 p-2 ">
                        @foreach ($files as $index => $file)
                                <div class="flex justify-between items-center bg-white p-2 mt-1">
                                    <small class="text-blue-700 text-xs ">{{$index+1}}. {{ $file->getClientOriginalName() }} <span wire:loading wire:target="removeFile({{ $index }})"><svg aria-hidden="true" class="w-3 h-3 mt-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg></span></small>
                                    
                                    <a href="#" wire:click="removeFile({{ $index }})"
                                        class="text-red-500 hover:text-red-700">&times;
                                    </a>
                                </div>
                                @error('files.'.$index)
                                <div class="flex items-center text-sm text-red-500">
                                    <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <small>{{ $message }}</small>
                                </div>  
                                @enderror
                             
                        @endforeach
                        </div>   
                        @endif
                    </div>

                    <img src="" class="mt-4 mx-auto max-h-40 hidden" id="preview">

                </div>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Fichiers valides : Image(PNG, JPEG), Text, PDF, Word, Excel, CSV, PowerPoint
                </p>
            </div>

           

            <!-- Error Display -->
            <div id="div_error">
                @if ($errors->has('files'))
                    <div class="flex items-center text-sm text-red-500">
                        <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                clip-rule="evenodd" />
                        </svg>

                        <small>{{ $errors->first('files') }}</small>
                    </div>
                @endif
            </div>

            <div>
                <label for="mot_cle" class="text-gray-900 dark:text-gray-300">
                    Mot clé de recherche
                </label>
                <input wire:model="mot_cle" id="mot_cle" name="mot_cle"
                    class="block w-full text-sm text-gray-900 border rounded-lg bg-gray-50 dark:text-gray-400 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600"
                    type="text" />
                @error('mot_cle')
                    <div class="flex items-center text-sm text-red-500">
                        <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div>
                <label class="inline-flex items-center mb-5 cursor-pointer">
                    <input wire:model.live="confidence" type="checkbox" value="" class="sr-only peer">
                    <div
                        class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Rendre le document
                        confidentiel</span>
                </label>
            </div>

            <!-- Service Selection Section -->
            <div>
                <div class="inline-flex items-center space-x-10">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Sélectionner les services
                        @if ($confidence)
                            <button type="button">
                                <svg class="w-4 h-4 text-blue-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M17 10v1.126c.367.095.714.24 1.032.428l.796-.797 1.415 1.415-.797.796c.188.318.333.665.428 1.032H21v2h-1.126c-.095.367-.24.714-.428 1.032l.797.796-1.415 1.415-.796-.797a3.979 3.979 0 0 1-1.032.428V20h-2v-1.126a3.977 3.977 0 0 1-1.032-.428l-.796.797-1.415-1.415.797-.796A3.975 3.975 0 0 1 12.126 16H11v-2h1.126c.095-.367.24-.714.428-1.032l-.797-.796 1.415-1.415.796.797A3.977 3.977 0 0 1 15 11.126V10h2Zm.406 3.578.016.016c.354.358.574.85.578 1.392v.028a2 2 0 0 1-3.409 1.406l-.01-.012a2 2 0 0 1 2.826-2.83ZM5 8a4 4 0 1 1 7.938.703 7.029 7.029 0 0 0-3.235 3.235A4 4 0 0 1 5 8Zm4.29 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h6.101A6.979 6.979 0 0 1 9 15c0-.695.101-1.366.29-2Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div wire:loading.inline-flex wire:target="service_id">
                                <svg aria-hidden="true"
                                    class="w-4 h-4 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                            </div>
                        @endif
                    </h3>
                </div>
                <ul
                    class="w-full text-sm font-medium bg-white border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                    <li class=" flex flex-col gap-3 px-3 py-2 border-b dark:border-gray-600">
                        <div>
                            <input disabled wire:model.live="service_id" id="service-checkbox-{{ $service->id }}"
                                type="checkbox" value="{{ $service->id }}"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600"
                                {{ $service->id == $service_id ? 'checked' : '' }} />
                            <label for="service-checkbox-{{ $service->id }}"
                                class="text-gray-900 dark:text-gray-300">
                                {{ $service->nom }}
                            </label>
                        </div>
                        @if ($confidence and in_array($service->id, $service_id))
                            <div>
                                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Qui peut voir ?</h3>
                                <div class="bg-white rounded-lg shadow w-60 dark:bg-gray-700">
                                    <ul class="px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200">
                                        @foreach ($service['users'] as $user)
                                            @if (($user->role->nom == 'SuperAdministrateur') | ($user->id == Auth::user()->id))
                                            @else
                                                <li>
                                                    <div
                                                        class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <input id="checkbox-item-{{ $user->id }}"
                                                            wire:model="users_confidence" type="checkbox"
                                                            value="{{ $user->id }}"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                        <label for="checkbox-item-{{ $user->id }}"
                                                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                                            {{ $user->name }}</label>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </li>
                </ul>
                @error('service_id')
                    <div class="flex items-center text-sm text-red-500">
                        <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p>{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div>
                <!-- Buttons -->
                <div class="flex justify-end gap-4">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Enregistrer

                        <div wire:loading wire:target="save" role="status">
                            <svg aria-hidden="true"
                                class="w-4 h-4 me-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
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

                    </button>
                    <button id="annul_button" data-modal-hide="static-modal-doc" type="button" wire:click="removeAll()"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Annuler
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('files-cleared', () => {
           if (fileTotal>0) {
               fileTotal -=1
           }
       })
       document.addEventListener('files-cleared-all', () => {
           if (fileTotal>0) {
               fileTotal =0
           }
       })
       // Lorsque l'upload démarre, réinitialise la barre à 0%
       let bar_upload_file_progress = document.getElementById('bar-upload-file-progress')       
       document.addEventListener('livewire-upload-start', () => { 
           if (fileTotal>0) {
             @this.set('compteFileSelected',fileTotal)  
           }           
           const progressElem = document.getElementById('progress');
           const progressText = document.getElementById('progressText');
           if (progressElem) {
               
               progressElem.style.width = '0%';
           }
           if (progressText) {
               progressText.textContent = '0%';
           }
       });

       // Met à jour la barre en fonction de la progression (Livewire envoie event.detail.progress)
       document.addEventListener('livewire-upload-progress', event => {
      
           bar_upload_file_progress.style.display="block"
           const progress = event.detail.progress; // Progression en pourcentage (0 à 100)
           const progressElem = document.getElementById('progress');
           const progressText = document.getElementById('progressText');
           console.log('start loading '+ progress)
           if (progressElem) {
               progressElem.style.width = progress + '%';
           }
           if (progressText) {
               if(progress==100){
                 progressText.textContent = 'patienz !';
               }else{
                 progressText.textContent = progress + '%';  
               }
               
           }
       });

       // Une fois l'upload terminé, positionne la barre à 100%
       document.addEventListener('livewire-upload-finish', () => {
           const progressElem = document.getElementById('progress');
           const progressText = document.getElementById('progressText');
           if (progressElem) {
               progressElem.style.width = '100%';
           }
           if (progressText) {
               progressText.textContent = '100%';
           }
       });

       // En cas d'erreur, réinitialise la barre à 0%
       document.addEventListener('livewire-upload-error', () => {

           const progressElem = document.getElementById('progress');
           const progressText = document.getElementById('progressText');
           if (progressElem) {
               progressElem.style.width = '0%';
           }
           if (progressText) {
               progressText.textContent = '0%';
           }
       });
   </script>
   

   <script>
       // Gestion du Drag & Drop
       const dropzone = document.getElementById('dropzone');
       const inputs = document.getElementById('upload');
       let fileTotal=0;
       // Gestion des événements de glisser-déposer
       ['dragover', 'dragleave', 'drop'].forEach(event => {
           dropzone.addEventListener(event, preventDefaults);
       });

       function preventDefaults(e) {
           e.preventDefault();
           e.stopPropagation();
       }

       // Mise à jour des styles
       ['dragover'].forEach(event => {
           dropzone.addEventListener(event, () => {
               dropzone.classList.add('border-indigo-600');
           });
       });

       ['dragleave', 'drop'].forEach(event => {
           dropzone.addEventListener(event, () => {
               dropzone.classList.remove('border-indigo-600');
           });
       });
       // Gestion du dépôt de fichier
       dropzone.addEventListener('drop', handleDrop);
       inputs.addEventListener('change', function (e) {
           const files = e.target.files;
           if (files.length) {
               if (fileTotal>0) {
               fileTotal+=files.length 
               }else{
                   fileTotal=files.length
               }
           }
       });
       function handleDrop(e) {
           const dt = e.dataTransfer;
           const files = dt.files;
           
           if (files.length) {
               [...files].forEach(file => {
               const dataTransfer = new DataTransfer();
               
               dataTransfer.items.add(file);
               inputs.files = dataTransfer.files;

               // Déclenche l'événement Livewire
               const changeEvent = new Event('change', {
                   bubbles: true
               });
               inputs.dispatchEvent(changeEvent);
           })            
           }
       }



     let close_button = document.getElementById('close_button')
     close_button.addEventListener('click', function(){
        // Sélectionne toutes les cases à cocher ayant l'ID qui commence par "service-checkbox-"
        let checkboxes = document.querySelectorAll("input[type='checkbox'][id^='service-checkbox-']");
       
       // Boucle sur chaque case et la décoche
       checkboxes.forEach(checkbox => {
           checkbox.checked = false;
       });
     })

       // Prévisualisation des images
       /*
       input.addEventListener('change', function(e) {
           const file = e.target.files[0];
           if (file && file.type.startsWith('image/')) {
               const reader = new FileReader();
               reader.onload = function(event) {
                   const preview = document.getElementById('preview');
                   preview.src = event.target.result;
                   preview.classList.remove('hidden');
               };
               reader.readAsDataURL(file);
           }
       });
       */
   </script>
</div>
