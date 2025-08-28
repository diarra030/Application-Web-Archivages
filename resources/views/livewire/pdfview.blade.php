<div>
    <div class="bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center min-h-screen">
        <!-- Conteneur principal -->
        <div
            class="relative w-full h-screen bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 flex flex-col">
            <!-- En-tête -->

            <header class="flex items-center justify-between px-6 py-3 bg-blue-600 rounded-t-lg flex-shrink-0">
                <h1 class="text-lg font-semibold text-white">Aperçu du document</h1>

                <div class="flex items-center space-x-4">
                    <button onclick="window.history.back()" class="text-white hover:text-gray-300 focus:outline-none">
                        <div class="inline-flex space-x-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Retour</span>
                        </div>
                    </button>

                    <button id="toggle-aside"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-2 py-1 rounded shadow">
                        ⬅️ Masquer infos
                    </button>
                </div>
            </header>

            <!-- Contenu principal -->
            <div class="grid grid-cols-1 md:grid-cols-4 flex-1 overflow-hidden">
                <!-- Aperçu du document (colonne principale) -->
                <div id="main-viewer" class="col-span-3 flex flex-col overflow-hidden">
                    @php
                        $isPDF = in_array($document->type, ['pdf', 'PDF']);
                        $isImageOrText = in_array($document->type, ['txt', 'png', 'jpeg', 'PNG', 'JPEG', 'jpg', 'JPG']);
                        $isVideo = in_array($document->type, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', '3gp', 'm4v']);
                        $readOnly = $permission === 'L';
                    @endphp
                    
                    @if ($isVideo)
                        {{-- 🎬 LECTEUR VIDÉO --}}
                        <div class="flex-1 bg-black flex items-center justify-center p-4">
                            <div >
                                <!-- Lecteur vidéo principal -->
                                <video id="main-video-player" style="height: 308px; width:600px"
                                       class=" object-contain rounded-lg shadow-lg" 
                                       preload="metadata"
                                       {{-- poster="{{ asset('img/video.jpg') }}" --}}
                                       >
                                    <source src="{{ asset('storage/' . $document->filename) }}" type="video/{{ $document->type }}">
                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                </video>
                                
                                <!-- Contrôles personnalisés additionnels -->
                                <div class="mt-4 flex justify-between items-center bg-gray-800 text-white p-3 rounded-lg">
                                    <div class="flex space-x-3">
                                        <button id="play-pause-btn" 
                                                onclick="toggleVideoPlayPause()" 
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded flex items-center space-x-2">
                                            <svg id="play-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                            <svg id="pause-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6 4h4v12H6V4zM14 4h4v12h-4V4z"/>
                                            </svg>
                                            <span id="play-pause-text">Lecture</span>
                                        </button>
                                        
                                        <button onclick="toggleVideoMute()" 
                                                class="px-3 py-2 bg-gray-600 hover:bg-gray-700 rounded">
                                            <svg id="volume-icon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.617.788L4.828 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.828l3.555-3.788a1 1 0 011.617.788z"/>
                                                <path d="M15.657 6.343a1 1 0 010 1.414 4 4 0 010 5.657 1 1 0 11-1.414-1.414 2 2 0 000-2.828 1 1 0 010-1.414z"/>
                                            </svg>
                                        </button>
                                        
                                        <button onclick="toggleVideoFullscreen()" 
                                                class="px-3 py-2 bg-gray-600 hover:bg-gray-700 rounded">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 1v10h10V5H5z"/>
                                                <path d="M7 7h2v2H7V7zm4 0h2v2h-2V7zm-4 4h2v2H7v-2zm4 0h2v2h-2v-2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Informations de lecture -->
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex items-center space-x-2">
                                            <span>Volume:</span>
                                            <input type="range" id="volume-slider" min="0" max="100" value="100" 
                                                   onchange="changeVideoVolume(this.value)"
                                                   class="w-20 h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer">
                                        </div>
                                        <div>
                                            <span id="video-current-time">00:00</span> / 
                                            <span id="video-duration">00:00</span>
                                        </div>
                                        <div class="text-gray-400">
                                            Type: {{ strtoupper($document->type) }}
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Barre de progression personnalisée -->
                                <div class="mt-2">
                                    <input type="range" id="progress-slider" min="0" max="100" value="0" 
                                           oninput="seekVideo(this.value)"
                                           class="w-full h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer">
                                </div>
                            </div>
                        </div>

                        <script>
                            let videoPlayer = null;
                            let isPlaying = false;

                            document.addEventListener('DOMContentLoaded', function() {
                                videoPlayer = document.getElementById('main-video-player');
                                const playIcon = document.getElementById('play-icon');
                                const pauseIcon = document.getElementById('pause-icon');
                                const playPauseText = document.getElementById('play-pause-text');
                                const currentTimeSpan = document.getElementById('video-current-time');
                                const durationSpan = document.getElementById('video-duration');
                                const progressSlider = document.getElementById('progress-slider');
                                const volumeSlider = document.getElementById('volume-slider');

                                // Mise à jour des informations de temps
                                videoPlayer.addEventListener('loadedmetadata', function() {
                                    durationSpan.textContent = formatTime(videoPlayer.duration);
                                });

                                videoPlayer.addEventListener('timeupdate', function() {
                                    currentTimeSpan.textContent = formatTime(videoPlayer.currentTime);
                                    
                                    // Mise à jour de la barre de progression
                                    if (videoPlayer.duration) {
                                        const progress = (videoPlayer.currentTime / videoPlayer.duration) * 100;
                                        progressSlider.value = progress;
                                    }
                                });

                                // Gestion des événements play/pause
                                videoPlayer.addEventListener('play', function() {
                                    isPlaying = true;
                                    playIcon.classList.add('hidden');
                                    pauseIcon.classList.remove('hidden');
                                    playPauseText.textContent = 'Pause';
                                });

                                videoPlayer.addEventListener('pause', function() {
                                    isPlaying = false;
                                    playIcon.classList.remove('hidden');
                                    pauseIcon.classList.add('hidden');
                                    playPauseText.textContent = 'Lecture';
                                });

                                // Mise à jour du volume
                                videoPlayer.volume = volumeSlider.value / 100;
                            });

                            function toggleVideoPlayPause() {
                                if (videoPlayer) {
                                    if (isPlaying) {
                                        videoPlayer.pause();
                                    } else {
                                        videoPlayer.play();
                                    }
                                }
                            }

                            function toggleVideoMute() {
                                if (videoPlayer) {
                                    videoPlayer.muted = !videoPlayer.muted;
                                    const volumeIcon = document.getElementById('volume-icon');
                                    if (videoPlayer.muted) {
                                        volumeIcon.classList.add('text-red-500');
                                    } else {
                                        volumeIcon.classList.remove('text-red-500');
                                    }
                                }
                            }

                            function toggleVideoFullscreen() {
                                if (videoPlayer) {
                                    if (videoPlayer.requestFullscreen) {
                                        videoPlayer.requestFullscreen();
                                    } else if (videoPlayer.webkitRequestFullscreen) {
                                        videoPlayer.webkitRequestFullscreen();
                                    } else if (videoPlayer.msRequestFullscreen) {
                                        videoPlayer.msRequestFullscreen();
                                    }
                                }
                            }

                            function changeVideoVolume(value) {
                                if (videoPlayer) {
                                    videoPlayer.volume = value / 100;
                                    videoPlayer.muted = value == 0;
                                }
                            }

                            function seekVideo(value) {
                                if (videoPlayer && videoPlayer.duration) {
                                    const seekTime = (value / 100) * videoPlayer.duration;
                                    videoPlayer.currentTime = seekTime;
                                }
                            }

                            function formatTime(seconds) {
                                if (isNaN(seconds)) return '00:00';
                                
                                const hours = Math.floor(seconds / 3600);
                                const minutes = Math.floor((seconds % 3600) / 60);
                                const remainingSeconds = Math.floor(seconds % 60);
                                
                                if (hours > 0) {
                                    return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
                                } else {
                                    return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
                                }
                            }
                        </script>
                        
                    @elseif ($isPDF && $readOnly)
                        {{-- 📄 PDF Lecture seule avec navigation personnalisée --}}
                        <div class="flex justify-end items-center space-x-2 mb-2 px-4 pt-2 flex-shrink-0">
                            <button id="prev-page"
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50">◀
                                Précédent</button>
                            <span id="page-info" class="text-gray-800 font-semibold"></span>
                            <button id="next-page"
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50">Suivant
                                ▶</button>
                            <button id="zoom-out" class="px-3 py-1 bg-gray-300 hover:bg-gray-400 text-black rounded">➖
                                Zoom -</button>
                            <button id="zoom-in" class="px-3 py-1 bg-gray-300 hover:bg-gray-400 text-black rounded">➕
                                Zoom +</button>
                        </div>

                        <div id="pdf-container" class="flex-1 overflow-auto bg-gray-100 p-4 text-center">
                            <canvas id="pdf-canvas" class="mx-auto shadow-md rounded"></canvas>
                        </div>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const url = "{{ asset('storage/' . $document->filename) }}";
                                const canvas = document.getElementById('pdf-canvas');
                                const ctx = canvas.getContext('2d');
                                const prevBtn = document.getElementById('prev-page');
                                const nextBtn = document.getElementById('next-page');
                                const pageInfo = document.getElementById('page-info');
                                const zoomInBtn = document.getElementById('zoom-in');
                                const zoomOutBtn = document.getElementById('zoom-out');

                                let pdfDoc = null;
                                let currentPage = 1;
                                let totalPages = 0;
                                let currentScale = 1;
                                const scaleStep = 0.25;

                                pdfjsLib.GlobalWorkerOptions.workerSrc =
                                    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                                const renderPage = (pageNum) => {
                                    pdfDoc.getPage(pageNum).then(page => {
                                        const containerWidth = document.getElementById('pdf-container').clientWidth;
                                        const baseViewport = page.getViewport({
                                            scale: 1
                                        });
                                        const defaultScale = containerWidth / baseViewport.width;
                                        const effectiveScale = defaultScale * currentScale;

                                        const viewport = page.getViewport({
                                            scale: effectiveScale
                                        });
                                        canvas.width = viewport.width;
                                        canvas.height = viewport.height;

                                        const renderContext = {
                                            canvasContext: ctx,
                                            viewport: viewport
                                        };

                                        page.render(renderContext);
                                        pageInfo.textContent = `Page ${pageNum} sur ${totalPages}`;
                                        prevBtn.disabled = pageNum <= 1;
                                        nextBtn.disabled = pageNum >= totalPages;
                                    });
                                };

                                pdfjsLib.getDocument(url).promise.then(pdf => {
                                    pdfDoc = pdf;
                                    totalPages = pdf.numPages;
                                    renderPage(currentPage);
                                }).catch(err => {
                                    canvas.parentElement.innerHTML = `<p class="text-red-600">Erreur PDF : ${err.message}</p>`;
                                });

                                prevBtn.addEventListener('click', () => {
                                    if (currentPage > 1) {
                                        currentPage--;
                                        renderPage(currentPage);
                                    }
                                });

                                nextBtn.addEventListener('click', () => {
                                    if (currentPage < totalPages) {
                                        currentPage++;
                                        renderPage(currentPage);
                                    }
                                });

                                zoomInBtn.addEventListener('click', () => {
                                    currentScale += scaleStep;
                                    renderPage(currentPage);
                                });

                                zoomOutBtn.addEventListener('click', () => {
                                    if (currentScale > scaleStep) {
                                        currentScale -= scaleStep;
                                        renderPage(currentPage);
                                    }
                                });
                            });
                        </script>
                        
                    @elseif ($isPDF || $isImageOrText)
                        {{-- 🖼️ PDF normal, TXT ou images - AVEC PROTECTION si lecture seule --}}
                        @if ($readOnly && in_array($document->type, ['png', 'jpeg', 'PNG', 'JPEG', 'jpg', 'JPG']))
                            {{-- 🔒 Images en mode lecture seule avec protection --}}
                            <div class="flex-1 overflow-auto bg-gray-100 p-4 text-center">
                                <img id="protected-image" src="{{ asset('storage/' . $document->filename) }}"
                                    class="mx-auto shadow-md rounded max-w-full h-auto" alt="Document protégé">
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const img = document.getElementById('protected-image');

                                    // Même protection que pour les PDFs
                                    img.addEventListener('contextmenu', function(e) {
                                        e.preventDefault();
                                    });

                                    img.addEventListener('dragstart', function(e) {
                                        e.preventDefault();
                                    });

                                    // Désactiver la sélection
                                    img.style.userSelect = 'none';
                                    img.style.webkitUserSelect = 'none';
                                    img.style.mozUserSelect = 'none';
                                    img.style.msUserSelect = 'none';

                                    // Désactiver le drag
                                    img.style.webkitUserDrag = 'none';
                                    img.style.mozUserDrag = 'none';
                                    img.style.userDrag = 'none';

                                    // Bloquer les tentatives de sauvegarde
                                    img.addEventListener('mousedown', function(e) {
                                        if (e.button === 0) { // Clic gauche
                                            e.preventDefault();
                                        }
                                    });
                                });
                            </script>
                        @else
                            {{-- 🖼️ PDF normal, TXT ou images sans protection --}}
                            <iframe src="{{ asset('storage/' . $document->filename) }}"
                                class="w-full h-full border-none rounded-bl-lg flex-1 min-h-0"></iframe>
                        @endif
                    @elseif ($isOfficeDocument)
                        {{-- 📁 Documents Office affichés depuis /archives - AVEC HAUTEUR COMPLETE --}}
                        <iframe src="{{ asset('storage/archives/' . $nom) }}"
                            class="w-full h-full border-none rounded-bl-lg flex-1 min-h-0">
                        </iframe>
                    @else
                        {{-- ❌ Format non reconnu --}}
                        <div
                            class="w-full h-full bg-yellow-100 p-6 rounded-bl-lg flex items-center justify-center text-gray-700 flex-1">
                            <div class="text-center">
                                <div class="text-6xl mb-4">📄</div>
                                <p class="text-lg font-semibold mb-2">Format non prévisualisable</p>
                                <p class="text-gray-600">Ce format de fichier ({{ strtoupper($document->type) }}) n'est pas prévisualisable directement.</p>
                                <p class="text-gray-600 mt-2">Téléchargez-le ou ouvrez-le dans une application compatible.</p>
                                
                                @if ($showOpenButton)
                                    <div class="mt-4">
                                        <a href="{{ asset('storage/' . $document->filename) }}" 
                                           download="{{ $document->nom }}.{{ $document->type }}"
                                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 inline-flex items-center space-x-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                                            </svg>
                                            <span>Télécharger le fichier</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <aside id="doc-aside"
                    class="bg-gray-50 p-6 dark:bg-gray-700 rounded-br-lg border-l border-gray-200 dark:border-gray-600 space-y-3 overflow-y-auto">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Informations sur le document</h2>
                    <ul class="mt-4 space-y-2 text-gray-600 dark:text-gray-400">
                        <li><strong>Titre :</strong> {{ $document->nom }}</li>
                        <li><strong>Type du fichier :</strong> {{ strtoupper($document->type) }}</li>
                        @if ($isVideo)
                            <li><strong>Format :</strong> Vidéo {{ strtoupper($document->type) }}</li>
                            <li><strong>Taille :</strong> {{ number_format($document->taille / 1024, 1) }} MB</li>
                        @else
                            <li><strong>Taille :</strong> {{ $document->taille }} KB</li>
                        @endif
                        <li><strong>Auteur :</strong> {{ $document->user->name }}</li>
                        @php
                            $lines = explode("\n", $document->content); // Divise le contenu en lignes
                            $lastLine = end($lines); // Récupère la dernière ligne
                        @endphp
                        <li><strong>Mot clé de recherche :</strong> {{ $lastLine }}</li>
                        <li><strong>Date de création :</strong> {{ $document->created_at->format('d/m/Y') }}</li>
                    </ul>
                    <div class="pdf-viewer-container">

                        {{-- Infos document --}}
                        <div class="document-info mb-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">
                                        Créé par : {{ $document->user->name ?? 'Utilisateur supprimé' }}
                                    </p>
                                </div>

                                {{-- Badge de permission --}}
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl">{{ $this->getPermissionIcon() }}</span>
                                    <span
                                        class="px-3 py-1 text-xs font-medium rounded-full
                                        @if ($permission === 'LE') bg-green-100 text-green-800
                                        @elseif($permission === 'E') bg-blue-100 text-blue-800
                                        @elseif($permission === 'L') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $this->getPermissionLabel() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Messages de session --}}
                        @if (session()->has('message'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ session('message') }}
                                </div>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif

                        {{-- Bloc accès refusé --}}
                        @if (!$hasAccess)
                            <div class="text-center py-8">
                                <div class="text-6xl mb-4">🚫</div>
                                <h2 class="text-xl font-semibold text-gray-700 mb-2">Accès refusé</h2>
                                <p class="text-gray-600">Vous n'avez pas la permission d'accéder à ce document.</p>
                            </div>
                        @else
                            {{-- Viewer PDF --}}
                            <div class="pdf-content mb-6">
                                <div
                                    class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    {{-- <div class="text-4xl mb-4">📄</div>
                                    <p class="text-gray-600">Visualiseur PDF</p>
                                    <p class="text-sm text-gray-500 mt-2">Le contenu du PDF sera affiché ici</p> --}}
                                </div>
                            </div>

                            {{-- Boutons d'action --}}
                            <div class="actions-buttons">
                                <div class="flex flex-col items-center space-y-2 w-full">

                                    {{-- Message --}}
                                    @if ($showMessageButton)
                                        <a href="{{ route('tag', $document->id) }}">
                                            <button type="button"
                                                class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                </svg>
                                                Laisser un message
                                            </button>
                                        </a>
                                    @endif

                                    {{-- Ouvrir --}}
                                    @if ($showOpenButton)
                                        <a href="{{ asset('storage/' . $document->filename) }}" target="_blank">
                                            <button type="button"
                                                class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                                </svg>
                                                Ouvrir hors de l'application
                                            </button>
                                        </a>
                                    @endif

                                    {{-- Éditer --}}
                                    @if ($showEditButton)
                                        <a href="{{ route('documents.edit', $document->id) }}" target="_blank">
                                            <button type="button"
                                                class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-green-500 rounded-lg hover:bg-green-600 focus:ring-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                                Éditer document
                                            </button>
                                        </a>
                                    @endif
                                </div>

                                {{-- Aucun bouton --}}
                                @if (!$showMessageButton && !$showOpenButton && !$showEditButton)
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">Aucune action disponible pour ce document.</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Infos de debug (dev uniquement) --}}
                        @if (config('app.debug'))
                            <div class="debug-info mt-6 p-4 bg-gray-100 rounded-lg border-l-4 border-gray-400">
                                <h4 class="font-semibold text-gray-700 mb-2">Informations de debug</h4>
                                <div class="text-sm text-gray-600 space-y-1">
                                    <div><strong>Permission actuelle:</strong> {{ $permission ?? 'Aucune' }}</div>
                                    <div><strong>Accès autorisé:</strong> {{ $hasAccess ? 'Oui' : 'Non' }}</div>
                                    <div><strong>Utilisateur:</strong> {{ auth()->user()->name ?? 'Non connecté' }}
                                    </div>
                                    <div><strong>Propriétaire du document:</strong>
                                        {{ $document->user->name ?? 'Inconnu' }}</div>
                                    <div><strong>Type de fichier:</strong> {{ $document->type }}</div>
                                    <div><strong>Est une vidéo:</strong> {{ $isVideo ? 'Oui' : 'Non' }}</div>
                                    <div><strong>Boutons visibles:</strong>
                                        @if ($showMessageButton)
                                            Message
                                        @endif
                                        @if ($showOpenButton)
                                            Ouvrir
                                        @endif
                                        @if ($showEditButton)
                                            Éditer
                                        @endif
                                        @if (!$showMessageButton && !$showOpenButton && !$showEditButton)
                                            Aucun
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
    (function() {
        'use strict';

        const USER_PERMISSION = '{{ $permission ?? 'N' }}'; // L = Lecture
        const IS_READONLY = USER_PERMISSION === 'L';
        const IS_VIDEO = {{ $isVideo ? 'true' : 'false' }};

        if (!IS_READONLY) return; // Protection uniquement en mode lecture seule

        alert(IS_VIDEO ? '[🔒] Mode lecture seule activé - Vidéo protégée' : '[🔒] Mode lecture seule activé');

        // 🔒 Blocage clic droit global
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            showProtectionMessage('Clic droit désactivé');
        });

        // 🔒 Blocage raccourcis clavier dangereux
        document.addEventListener('keydown', function(e) {
            const key = e.key.toLowerCase();
            const ctrl = e.ctrlKey;
            const shift = e.shiftKey;
            const alt = e.altKey;

            const blocked = [
                (ctrl && key === 's'), // Enregistrer
                (ctrl && key === 'p'), // Imprimer
                (ctrl && key === 'c'), // Copier
                (ctrl && key === 'x'), // Couper
                (ctrl && key === 'a'), // Tout sélectionner
                (key === 'f12'), // Dev tools
                (ctrl && shift && key === 'i'), // Dev tools
                (ctrl && shift && key === 'c'), // Dev tools
                (ctrl && shift && key === 'j'), // Console
                (ctrl && key === 'u'), // Source
                (ctrl && key === 't'), // Nouvel onglet
                (ctrl && key === 'f'), // Rechercher
                (ctrl && key === 'h'), // Historique
                (ctrl && key === 'd'), // Favoris
                (ctrl && key === 'j'), // Téléchargements
            ];

            if (blocked.some(Boolean)) {
                e.preventDefault();
                e.stopPropagation();
                showProtectionMessage(`Raccourci ${key.toUpperCase()} bloqué`);
            }
        });

        // 🔒 Blocage impression (CSS print)
        const style = document.createElement('style');
        style.textContent = `
                @media print {
                    body * { display: none !important; }
                    body::after {
                        content: "Impression désactivée - Document protégé, vous êtes en mode lecture seul:\\ 🔒 Blocage impression veuillez bien contacter votre Administrateur";
                        display: block;
                        font-size: 20px;
                        text-align: center;
                        padding: 200px;
                    }
                }
            `;

        document.head.appendChild(style);

        // 🔒 Blocage copier
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            showProtectionMessage('Copie désactivée');
            if (e.clipboardData) {
                e.clipboardData.setData('text/plain', 'Document protégé - copie interdite');
            }
        });

        // 🔒 Protection spécifique aux vidéos
        if (IS_VIDEO) {
            document.addEventListener('DOMContentLoaded', function() {
                const videoPlayer = document.getElementById('main-video-player');
                if (videoPlayer) {
                    // Désactiver le clic droit sur la vidéo
                    videoPlayer.addEventListener('contextmenu', function(e) {
                        e.preventDefault();
                        showProtectionMessage('Clic droit sur la vidéo désactivé');
                    });

                    // Désactiver la sélection de la vidéo
                    videoPlayer.style.userSelect = 'none';
                    videoPlayer.style.webkitUserSelect = 'none';
                    videoPlayer.style.mozUserSelect = 'none';
                    videoPlayer.style.msUserSelect = 'none';

                    // Désactiver le drag de la vidéo
                    videoPlayer.addEventListener('dragstart', function(e) {
                        e.preventDefault();
                    });

                    // Bloquer l'enregistrement de la vidéo
                    videoPlayer.addEventListener('mousedown', function(e) {
                        if (e.button === 2) { // Clic droit
                            e.preventDefault();
                        }
                    });

                    // Désactiver les options de téléchargement dans les contrôles
                    videoPlayer.setAttribute('controlsList', 'nodownload nofullscreen noremoteplayback');
                    
                    // Supprimer l'attribut download si présent
                    videoPlayer.removeAttribute('download');
                    
                    // Protection contre l'ouverture dans un nouvel onglet
                    videoPlayer.addEventListener('click', function(e) {
                        if (e.ctrlKey || e.metaKey) {
                            e.preventDefault();
                            showProtectionMessage('Ouverture dans un nouvel onglet bloquée');
                        }
                    });

                    // Bloquer l'ouverture de l'URL de la vidéo directement
                    videoPlayer.addEventListener('loadstart', function() {
                        // Empêcher l'accès direct à l'URL via inspection
                        console.log = function() {};
                        console.warn = function() {};
                        console.error = function() {};
                    });

                    // Protection contre l'enregistrement via raccourcis navigateur
                    document.addEventListener('keydown', function(e) {
                        // Bloquer Ctrl+Maj+S (enregistrer en tant que) dans certains navigateurs
                        if (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === 's') {
                            e.preventDefault();
                            showProtectionMessage('Enregistrement vidéo bloqué');
                        }
                        
                        // Bloquer F12 spécifiquement sur la vidéo
                        if (e.key === 'F12' && e.target === videoPlayer) {
                            e.preventDefault();
                            showProtectionMessage('DevTools bloqués sur la vidéo');
                        }
                    });
                }

                // Protection des contrôles personnalisés
                const customControls = document.querySelectorAll('#play-pause-btn, #volume-slider, #progress-slider');
                customControls.forEach(control => {
                    control.addEventListener('contextmenu', function(e) {
                        e.preventDefault();
                        showProtectionMessage('Menu contextuel désactivé');
                    });
                });
            });

            // Bloquer les raccourcis spécifiques aux vidéos potentiellement dangereux
            document.addEventListener('keydown', function(e) {
                const key = e.key.toLowerCase();
                const ctrl = e.ctrlKey;
                
                // Raccourcis vidéo spécifiques à bloquer
                if (ctrl && key === 'enter') {
                    e.preventDefault();
                    showProtectionMessage('Plein écran via raccourci bloqué');
                }
            });
        }

        // 🔒 Détection basique des DevTools (méthode de détection de taille)
        let devtools = {
            open: false,
            orientation: null
        };

        const threshold = 160;

        setInterval(function() {
            if (window.outerHeight - window.innerHeight > threshold || 
                window.outerWidth - window.innerWidth > threshold) {
                if (!devtools.open) {
                    devtools.open = true;
                    showProtectionMessage('Outils de développement détectés');
                    if (IS_VIDEO) {
                        // Action spécifique pour les vidéos
                        const videoPlayer = document.getElementById('main-video-player');
                        if (videoPlayer) {
                            videoPlayer.pause();
                            showProtectionMessage('Lecture vidéo suspendue - DevTools détectés');
                        }
                    }
                }
            } else {
                devtools.open = false;
            }
        }, 500);

        // Protection anti-débogage
        function detectDevTool() {
            let start = +new Date();
            debugger;
            let end = +new Date();
            if(end - start > 100) {
                showProtectionMessage('Tentative de débogage détectée');
                if (IS_VIDEO) {
                    const videoPlayer = document.getElementById('main-video-player');
                    if (videoPlayer && !videoPlayer.paused) {
                        videoPlayer.pause();
                    }
                }
            }
        }
        
        // Vérification périodique du débogage
        setInterval(function() {
            detectDevTool();
        }, 2000);

        // Bloquer l'ouverture de nouvelles fenêtres/onglets
        window.addEventListener('beforeunload', function(e) {
            if (IS_VIDEO) {
                const message = 'Êtes-vous sûr de vouloir quitter ? La vidéo sera arrêtée.';
                e.returnValue = message;
                return message;
            }
        });

        function showProtectionMessage(message) {
            let alertDiv = document.getElementById('protection-alert');
            if (!alertDiv) {
                alertDiv = document.createElement('div');
                alertDiv.id = 'protection-alert';
                alertDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #dc2626;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-family: Arial, sans-serif;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            font-size: 14px;
            max-width: 300px;
            word-wrap: break-word;
                `;
                document.body.appendChild(alertDiv);
            }

            alertDiv.textContent = message;
            alertDiv.style.display = 'block';

            setTimeout(() => {
                alertDiv.style.display = 'none';
            }, 3000);
        }

        // Protection supplémentaire pour masquer les informations sensibles
        if (IS_VIDEO) {
            // Nettoyer la console pour éviter l'affichage d'informations
            console.clear();
            
            // Rediriger les logs de console
            const originalLog = console.log;
            console.log = function(...args) {
                // Ne pas afficher les logs en mode lecture seule
                return;
            };
        }

    })();
</script>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggle-aside');
            const aside = document.getElementById('doc-aside');
            const mainViewer = document.getElementById('main-viewer');

            let isHidden = false;

            toggleBtn.addEventListener('click', () => {
                isHidden = !isHidden;

                if (isHidden) {
                    aside.classList.add('hidden');
                    mainViewer.classList.remove('col-span-3');
                    mainViewer.classList.add('col-span-4');
                    toggleBtn.innerHTML = '➡️ Afficher infos';
                } else {
                    aside.classList.remove('hidden');
                    mainViewer.classList.remove('col-span-4');
                    mainViewer.classList.add('col-span-3');
                    toggleBtn.innerHTML = '⬅️ Masquer infos';
                }
            });
        });
    </script>

</div>