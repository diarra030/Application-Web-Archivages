
<div class="relative" wire:ignore.self>

    <style>
       .grossirDrag {
            
            background-color: rgba(175, 164, 164, 0.2);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 482.14 482.14"><g><path d="M302.599,0H108.966C80.66,0,57.652,23.025,57.652,51.315v379.509c0,28.289,23.008,51.315,51.314,51.315h264.205 c28.275,0,51.316-23.026,51.316-51.315V121.449L302.599,0z M373.171,450.698H108.966c-10.969,0-19.89-8.905-19.89-19.874V51.315 c0-10.953,8.921-19.858,19.89-19.858l181.875-0.189v67.218c0,19.653,15.949,35.603,35.588,35.603l65.877-0.189l0.725,296.925 C393.03,441.793,384.142,450.698,373.171,450.698z"/><path d="M241.054,150.96c-49.756,0-90.102,40.347-90.102,90.109c0,49.764,40.346,90.11,90.102,90.11 c49.771,0,90.117-40.347,90.117-90.11C331.171,191.307,290.825,150.96,241.054,150.96z M273.915,253.087h-20.838v20.835 c0,6.636-5.373,12.017-12.023,12.017c-6.619,0-12.01-5.382-12.01-12.017v-20.835H208.21c-6.637,0-12.012-5.383-12.012-12.018 c0-6.634,5.375-12.017,12.012-12.017h20.834v-20.835c0-6.636,5.391-12.018,12.01-12.018c6.65,0,12.023,5.382,12.023,12.018v20.835 h20.838c6.635,0,12.008,5.383,12.008,12.017C285.923,247.704,280.55,253.087,273.915,253.087z"/></g></svg>');
            background-repeat: no-repeat;
            background-size: 50px 50px; /* ou cover selon besoin */
            background-position: center;
            z-index: 1;
        }
        .grossirDrag * {
         opacity: 0.5; /* Rend les éléments enfants transparents */
        }
        /* From Uiverse.io by Galahhad */ 
        .switch {
        /* switch */
        --switch-width: 46px;
        --switch-height: 24px;
        --switch-bg: rgb(131, 131, 131);
        --switch-checked-bg: rgb(0, 218, 80);
        --switch-offset: calc((var(--switch-height) - var(--circle-diameter)) / 2);
        --switch-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
        /* circle */
        --circle-diameter: 18px;
        --circle-bg: #fff;
        --circle-shadow: 1px 1px 2px rgba(146, 146, 146, 0.45);
        --circle-checked-shadow: -1px 1px 2px rgba(163, 163, 163, 0.45);
        --circle-transition: var(--switch-transition);
        /* icon */
        --icon-transition: all .2s cubic-bezier(0.27, 0.2, 0.25, 1.51);
        --icon-cross-color: var(--switch-bg);
        --icon-cross-size: 6px;
        --icon-checkmark-color: var(--switch-checked-bg);
        --icon-checkmark-size: 10px;
        /* effect line */
        --effect-width: calc(var(--circle-diameter) / 2);
        --effect-height: calc(var(--effect-width) / 2 - 1px);
        --effect-bg: var(--circle-bg);
        --effect-border-radius: 1px;
        --effect-transition: all .2s ease-in-out;
        }

        .switch input {
        display: none;
        }

        .switch {
        display: inline-block;
        }

        .switch svg {
        -webkit-transition: var(--icon-transition);
        -o-transition: var(--icon-transition);
        transition: var(--icon-transition);
        position: absolute;
        height: auto;
        }

        .switch .checkmark {
        width: var(--icon-checkmark-size);
        color: var(--icon-checkmark-color);
        -webkit-transform: scale(0);
        -ms-transform: scale(0);
        transform: scale(0);
        }

        .switch .cross {
        width: var(--icon-cross-size);
        color: var(--icon-cross-color);
        }

        .slider {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        width: var(--switch-width);
        height: var(--switch-height);
        background: var(--switch-bg);
        border-radius: 999px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        position: relative;
        -webkit-transition: var(--switch-transition);
        -o-transition: var(--switch-transition);
        transition: var(--switch-transition);
        cursor: pointer;
        }

        .circle {
        width: var(--circle-diameter);
        height: var(--circle-diameter);
        background: var(--circle-bg);
        border-radius: inherit;
        -webkit-box-shadow: var(--circle-shadow);
        box-shadow: var(--circle-shadow);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-transition: var(--circle-transition);
        -o-transition: var(--circle-transition);
        transition: var(--circle-transition);
        z-index: 1;
        position: absolute;
        left: var(--switch-offset);
        }

        .slider::before {
        content: "";
        position: absolute;
        width: var(--effect-width);
        height: var(--effect-height);
        left: calc(var(--switch-offset) + (var(--effect-width) / 2));
        background: var(--effect-bg);
        border-radius: var(--effect-border-radius);
        -webkit-transition: var(--effect-transition);
        -o-transition: var(--effect-transition);
        transition: var(--effect-transition);
        }

        /* actions */

        .switch input:checked+.slider {
        background: var(--switch-checked-bg);
        }

        .switch input:checked+.slider .checkmark {
        -webkit-transform: scale(1);
        -ms-transform: scale(1);
        transform: scale(1);
        }

        .switch input:checked+.slider .cross {
        -webkit-transform: scale(0);
        -ms-transform: scale(0);
        transform: scale(0);
        }

        .switch input:checked+.slider::before {
        left: calc(100% - var(--effect-width) - (var(--effect-width) / 2) - var(--switch-offset));
        }

        .switch input:checked+.slider .circle {
        left: calc(100% - var(--circle-diameter) - var(--switch-offset));
        -webkit-box-shadow: var(--circle-checked-shadow);
        box-shadow: var(--circle-checked-shadow);
        }

    </style>

    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Ajouter un ou plusieurs documents
        </h3>
        <button id="close_button" type="button" wire:click="removeAll()"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
            data-modal-hide="uploadFile">
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
                            <input  type="file" id="upload" class="hidden" wire:model="files" multiple>
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
                
                        <div  class="w-full bg-gray-200 rounded-full h-2 mt-2 " id="bar-upload-file-progress" style="display: none">
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

                        
                            <div class="flex items-center text-sm text-red-500 hidden" id="empty" wire:ignore.self>
                                <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                clip-rule="evenodd" />
                                </svg>
                                <small>veillez selectionner un fichier valide</small>
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
            
               

            <div>
                
            <div class="flex flex-iterms">
                <div>
                    <label class="switch">
                        <input checked="" type="checkbox" wire:model="lock" wire:change="checkLock">
                        <div class="slider">
                            <div class="circle">
                                <svg class="cross" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 365.696 365.696" y="0" x="0" height="6" width="6" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path data-original="#000000" fill="currentColor" d="M243.188 182.86 356.32 69.726c12.5-12.5 12.5-32.766 0-45.247L341.238 9.398c-12.504-12.503-32.77-12.503-45.25 0L182.86 122.528 69.727 9.374c-12.5-12.5-32.766-12.5-45.247 0L9.375 24.457c-12.5 12.504-12.5 32.77 0 45.25l113.152 113.152L9.398 295.99c-12.503 12.503-12.503 32.769 0 45.25L24.48 356.32c12.5 12.5 32.766 12.5 45.247 0l113.132-113.132L295.99 356.32c12.503 12.5 32.769 12.5 45.25 0l15.081-15.082c12.5-12.504 12.5-32.77 0-45.25zm0 0"></path>
                                    </g>
                                </svg>
                                <svg class="checkmark" xml:space="preserve" style="enable-background:new 0 0 512 512" viewBox="0 0 24 24" y="0" x="0" height="10" width="10" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path class="" data-original="#000000" fill="currentColor" d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </label>   
                </div> 
                <div>
                    <p class="text-blue-600 font-bold"> Vérrouillage fichier(s)</p>
                </div>
            </div>
            @if ($lock)
                <div class="block max-w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <label for="phone-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Entrer code de verrouillage:</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input type="password" wire:model="code_verrouille" pattern="\d*" inputmode="numeric"  id="phone-input" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="code à 4chiffres EX:1234" maxlength="4" oninput="this.value = this.value.replace(/\D/g, '')"  />
                        </div>
                        @error('code_verrouille')
                            <div class="flex items-center text-sm text-red-500">
                                <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <p>Entrer un code à 4 chiffres</p>
                            </div>
                        @enderror
                </div> 
            @endif

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

            <div>
                <!-- Buttons -->
                <div class="flex justify-end gap-4">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" @click="enregistrer">
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
                    <button id="annul_button" data-modal-hide="uploadFile" type="button" wire:click="removeAll()"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        Annuler
                    </button>
                </div>
            </div>
        </form>
    </div>


    <script>
        let fileTotal =0
        function enregistrer(){
            if(inputs.value.length<1){
                document.getElementById('empty').classList.remove('hidden')
            }else{
                document.getElementById('empty').classList.add('hidden')
            }
        }
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
        document.addEventListener('resetJS',()=>{
            fileTotal =0
        })
        // Lorsque l'upload démarre, réinitialise la barre à 0%
        let bar_upload_file_progress = document.getElementById('bar-upload-file-progress')       
        document.addEventListener('livewire-upload-start', () => { 
       
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
                dropzone.classList.add('grossirDrag');
            });
        });

        ['dragleave', 'drop'].forEach(event => {
            dropzone.addEventListener(event, () => {
                
                dropzone.classList.remove('grossirDrag');
            });
        });
        // Gestion du dépôt de fichier
        dropzone.addEventListener('drop', handleDrop);
        inputs.addEventListener('change',function(){
            const selectedFiles = this.files; // ou inputs.files
            if (fileTotal > 0) {
                fileTotal += selectedFiles.length;
                @this.set('compteFileSelected',fileTotal)
            } else {
                fileTotal = selectedFiles.length;
                @this.set('compteFileSelected',fileTotal)
            }
            
        })
        function handleDrop(e) {
            e.preventDefault(); // important pour éviter comportement par défaut

            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length) {
                const dataTransfer = new DataTransfer(); // ← créer UNE seule fois

                [...files].forEach(file => {
                    dataTransfer.items.add(file);
                });

                inputs.files = dataTransfer.files;

                // Déclenche l'événement Livewire
                const changeEvent = new Event('change', {
                    bubbles: true
                });
                inputs.dispatchEvent(changeEvent);
            }
        }
        window.addEventListener('file_create',()=>{
            Swal.fire({
            title: 'Uploadé(s)!',
            text: 'Fichier(s) a bien été Uploadé.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        }); 
        })
        
    </script>
    

    



</div>
