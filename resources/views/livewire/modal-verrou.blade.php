<div>

<button data-modal-target="modalVerrou" class="hidde" id="modalVerrouBtn" data-modal-toggle="modalVerrou">
</button>

<div wire:ignore.self id="modalVerrou" data-modal-backdrop="static" data-modal-keyboard="false" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <button type="button" id="closeModalVerrou" class="hidden absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalVerrou" >
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-3 text-lg font-normal text-gray-500 dark:text-gray-400">Enter le code de dévérrouillage  </h3>
                    <div class="relative mb-3">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 10V7a4 4 0 1 1 8 0v3h1a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1Zm2-3a2 2 0 1 1 4 0v3h-4V7Zm2 6a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                            <input type="password" wire:model.defer="unlockCode" pattern="\d*" inputmode="numeric"  id="phone-input" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="code à 4chiffres EX:1234" maxlength="4" oninput="this.value = this.value.replace(/\D/g, '')"  />
                    </div>
                    @error('unlockCode') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                <button  type="button" wire:click="verifyCode" class="text-white bg-green-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium w-full rounded-lg text-sm flex items-center justify-center px-5 py-2.5 text-center">
                   Dévérouiller 
                   <span wire:loading>
                        <span role="status">
                            <svg aria-hidden="true" class="w-4 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                        </span>
                    </span>
                </button>
                <button onclick="window.history.back()" class="mt-1 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium w-full rounded-lg text-sm flex items-center justify-center px-5 py-2.5 text-center">
                Retour
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    // --- Livewire specific logic ---
    document.addEventListener('livewire:initialized', function () { 
        if(@this.get('accessGranted') == true){
            setTimeout(() => {
               document.getElementById('modalVerrouBtn').click()  
            }, 1500);
        }
        @this.on('checkAccess', ()=>{
             document.getElementById('closeModalVerrou').click()    
        })
    });

    // --- Force disable Escape key on modal ---
    window.addEventListener('keydown', function (event) {
        const modal = document.getElementById('modalVerrou');
        // Check if modal exists and is visible (doesn't have the 'hidden' class)
        if (modal && !modal.classList.contains('hidden') && event.key === 'Escape') {
            // Stop the event completely, before any other script can handle it.
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    }, true); // The 'true' enables capture mode, making this listener run first.
</script>