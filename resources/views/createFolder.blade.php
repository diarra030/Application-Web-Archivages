



<button data-modal-target="editFolder" id="lol" data-modal-toggle="editFolder" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 hidden" type="button">
</button>
<!--Modal creer le dossier-->
<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 bg-opacity-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"  wire:ignore.self >
      
    <div 
        x-data="{ show: false }"
        x-show="show"
        x-transition
        x-init="
            window.addEventListener('folderCreer', () => {
                show = true;
                setTimeout(() => show = false, 3000);
            });
        "
        class="fixed top-4 right-4 bg-green-600 text-white p-4 rounded shadow"
        style="display: none;"
    >
        <div class="max-w-sm">
            <div class="p-4 mb-4 text-sm text-white bg-green-500 dark:bg-green-800 dark:text-white" role="alert" >
                <span class="font-medium">Dossier créé avec success!</span> .
            </div>
        </div>
    </div> 
    <div 
        x-data="{ show: false }"
        x-show="show"
        x-transition
        x-init="
            window.addEventListener('folderCreerexist', () => {
                show = true;
                setTimeout(() => show = false, 3000);
            });
        "
        class="fixed top-4 right-4 text-white p-4 rounded shadow"
        style="display: none;"
    >
        <div class="max-w-sm">
            <div class="p-4 mb-4 text-sm text-white bg-red-500 dark:bg-green-800 dark:text-white" role="alert" >
                <span class="font-medium">Dossier existe déjà !</span> .
            </div>
        </div>
    </div>
      <div class="relative p-4 w-full max-w-md max-h-full" >
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Créer un nouveau dossier
                    </h3>
                    <button type="button" wire:click="closeCreateModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Fermer modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-2">
                <div class="gap-2 mb-4 flex-col w-full">
                    <form wire:submit.prevent="createFolder">
                        @csrf
                        <div class="flex-col gap-2">
                            <input wire:model="folderName" type="text" maxlength="50" placeholder="Nom du dossier" class="border rounded p-2 w-full">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full mt-2"><small>Créer dossier</small>  
                                <span wire:loading wire:target='createFolder'>
                                    <span role="status">
                                        <svg aria-hidden="true" class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                    </span>
                                </span>
                            </button>  
                        </div>
                    
                    </form>
                </div>   
                </div>   
            </div>
        </div>
    </div>  

    <!--Modal renommer le dossier-->
    <div id="editFolder" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" wire:ignore.self>
        <div 
        x-data="{ show: false }"
        x-show="show"
        x-transition
        x-init="
            window.addEventListener('folderEdit', () => {
                show = true;
                setTimeout(() => show = false, 3000);
            });
        "
        class="fixed top-4 right-4 bg-green-600 text-white p-4 rounded shadow"
        style="display: none;"
    >
        <div class="max-w-sm">
            <div class="p-4 mb-4 text-sm text-white bg-green-500 dark:bg-green-800 dark:text-white" role="alert" >
                <span class="font-medium">Dossier Modifié avec success!</span> .
            </div>
        </div>
    </div> 
    <div 
        x-data="{ show: false }"
        x-show="show"
        x-transition
        x-init="
            window.addEventListener('folderCreerexist', () => {
                show = true;
                setTimeout(() => show = false, 3000);
            });
        "
        class="fixed top-4 right-4 text-white p-4 rounded shadow"
        style="display: none;"
    >
        <div class="max-w-sm">
            <div class="p-4 mb-4 text-sm text-white bg-red-500 dark:bg-green-800 dark:text-white" role="alert" >
                <span class="font-medium">Dossier existe déjà !</span> .
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-700 rounded-lg shadow w-full max-w-md p-4">
        <div class="flex justify-between items-center border-b pb-2">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifier le nom du dossier </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editFolder">
               X
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        
        <div class="mt-4">
            @error('folderName')
                <div class="flex items-center text-sm text-red-500">
                    <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                    clip-rule="evenodd" />
                    </svg>
                    <small>Entrer un Nom valide</small>
                </div>
            @enderror
            <form wire:submit.prevent="renamer">
                <input wire:model="folderName" wire:target='getFolderId'  wire:loading.attr="readonly" maxlength="50"
                       type="text" 
                       placeholder="Nom du dossier"
                       class="w-full border rounded p-2 mb-2"
                       wire:loading.class="bg-gray-200">
                <button type="submit" class="bg-blue-500 text-white rounded p-2 w-full">
                    <small>Renommer dossier</small>
                    <span wire:loading wire:target='getFolderId'><span role="status" class=""><svg aria-hidden="true" class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg></span></span>
                    <span wire:loading wire:target='renamer'>
                        <span role="status" class="">
                            <svg aria-hidden="true" class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600 " viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                        </span>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<!--Modal renommer le fichier-->
    <div id="editFile" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" wire:ignore.self>
        <div 
        x-data="{ show: false }"
        x-show="show"
        x-transition
        x-init="
            window.addEventListener('fileEdit', () => {
                show = true;
                setTimeout(() => show = false, 3000);
            });
        "
        class="fixed top-4 right-4 bg-green-600 text-white p-4 rounded shadow"
        style="display: none;"
    >
        <div class="max-w-sm">
            <div class="p-4 mb-4 text-sm text-white bg-green-500 dark:bg-green-800 dark:text-white" role="alert" >
                <span class="font-medium">Fichier Modifié avec success!</span> .
            </div>
        </div>
    </div> 
    <div 
        x-data="{ show: false }"
        x-show="show"
        x-transition
        x-init="
            window.addEventListener('fileexist', () => {
                show = true;
                setTimeout(() => show = false, 3000);
            });
        "
        class="fixed top-4 right-4 text-white p-4 rounded shadow"
        style="display: none;"
    >
        <div class="max-w-sm">
            <div class="p-4 mb-4 text-sm text-white bg-red-500 dark:bg-green-800 dark:text-white" role="alert" >
                <span class="font-medium">Fichier existe déjà !</span> .
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-700 rounded-lg shadow w-full max-w-md p-4">
        <div class="flex justify-between items-center border-b pb-2">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Modifier le nom du Fichier </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editFile">
               X
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        
        <div class="mt-4">
            @error('fileName')
                <div class="flex items-center text-sm text-red-500">
                    <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z"
                    clip-rule="evenodd" />
                    </svg>
                    <small>Entrer un Nom valide</small>
                </div>
            @enderror
            <form wire:submit.prevent="renameFile">
                <input wire:model="fileName" wire:target='getFileId'  wire:loading.attr="readonly" maxlength="50"
                       type="text" 
                       placeholder="Nom du fichier"
                       class="w-full border rounded p-2 mb-2"
                       wire:loading.class="bg-gray-200">
                <button type="submit" class="bg-blue-500 text-white rounded p-2 w-full">
                    <small>Renommer Fichier</small>
                    <span wire:loading wire:target='getFileId'><span role="status" class=""><svg aria-hidden="true" class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg></span></span>
                    <span wire:loading wire:target='renameFile'>
                        <span role="status" class="">
                            <svg aria-hidden="true" class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600 " viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                        </span>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

