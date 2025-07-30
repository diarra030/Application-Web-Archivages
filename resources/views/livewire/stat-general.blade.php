<div>
    <div class="bg-gray-100 p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Statistiques Générales</h1>

        <!-- Main Content -->
        <div class="main-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Statistique : Documents archivés -->
            <div
                class="stats bg-gradient-to-r from-blue-500 to-blue-700 text-white p-6 rounded-lg shadow-lg flex items-center transform transition-transform hover:scale-105 hover:shadow-2xl">
                <div class="icon bg-white bg-opacity-20 p-4 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3zM4 9v6c0 1.104.896 2 2 2h12c1.104 0 2-.896 2-2V9M6 11h12" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Documents archivés</h2>
                    <strong class="text-3xl font-extrabold count-up" data-target="{{ $documents }}"></strong>
                </div>
            </div>

            <!-- Statistique : Utilisateurs -->
            <div
                class="stats bg-gradient-to-r from-green-500 to-green-700 text-white p-6 rounded-lg shadow-lg flex items-center transform transition-transform hover:scale-105 hover:shadow-2xl">
                <div class="icon bg-white bg-opacity-20 p-4 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0a3 3 0 11-6 0m6 0a3 3 0 11-6 0m6 0h3m-6 0H6m12 0v-1m-12 0v-1m12 0H6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Utilisateurs</h2>
                    <strong class="text-3xl font-extrabold count-up" data-target="{{ $users }}"></strong>
                </div>
            </div>

            <!-- Statistique : Services -->
            <div
                class="stats bg-gradient-to-r from-purple-500 to-purple-700 text-white p-6 rounded-lg shadow-lg flex items-center transform transition-transform hover:scale-105 hover:shadow-2xl">
                <div class="icon bg-white bg-opacity-20 p-4 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-1a5 5 0 00-5-5h-2a5 5 0 00-5 5v1h5m-5-9a7 7 0 0014 0M5 4h14m-7 4h.01" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold">Services</h2>
                    <strong class="text-3xl font-extrabold count-up" data-target="{{ $services }}"></strong>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            animateNumbers();
        });

        Livewire.hook('message.processed', () => {
            animateNumbers(); // Relance l'animation après une mise à jour Livewire
        });

        function animateNumbers() {
            const counters = document.querySelectorAll('.count-up');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                let count = 0;
                const increment = target / 100;

                const updateCount = () => {
                    count += increment;
                    if (count < target) {
                        counter.innerText = Math.ceil(count);
                        requestAnimationFrame(updateCount);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        }
    </script>

</div>
