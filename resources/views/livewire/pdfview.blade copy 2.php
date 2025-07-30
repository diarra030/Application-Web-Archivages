<div>
    <div class="bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center">
        <!-- Conteneur principal -->
        <div
            class="relative w-full bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700">
            <!-- En-tête -->
           
            <header class="flex items-center justify-between px-6 py-3 bg-blue-600 rounded-t-lg">
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
            <div class="grid grid-cols-1 md:grid-cols-4">
                <!-- Aperçu du document (colonne principale) -->
                <div id="main-viewer" class="col-span-3">
                    @php
                        $isPDF = in_array($document->type, [
                            'pdf',
                            'PDF',
                            'txt',
                            'png',
                            'jpeg',
                            'PNG',
                            'JPEG',
                            'jpg',
                            'JPG',
                        ]);
                        $isImageOrText = in_array($document->type, ['txt', 'png', 'jpeg', 'PNG', 'JPEG', 'jpg', 'JPG']);
                        $readOnly = $permission === 'L';
                    @endphp
                    @if ($isPDF && $readOnly)
                        {{-- 📄 PDF Lecture seule avec navigation personnalisée --}}
                        <div class="flex justify-end items-center space-x-2 mb-2">
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

                        <div id="pdf-container" class="w-full h-full overflow-auto bg-gray-100 p-4 text-center">
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
                        {{-- 🖼️ PDF normal, TXT ou images --}}
                        <iframe src="{{ asset('storage/' . $document->filename) }}"class="w-full h-full border-none rounded-bl-lg"></iframe>
                    @elseif ($isOfficeDocument)
                        {{-- 📁 Documents Office affichés depuis /archives --}}
                        <iframe src="{{ asset('storage/archives/' . $nom) }}"
                            class="w-full h-full border-none rounded-bl-lg"> 
                        </iframe>
                    @else
                        {{-- ❌ Format non reconnu --}}
                        <div
                            class="w-full h-full bg-yellow-100 p-6 rounded-bl-lg flex items-center justify-center text-gray-700">
                            <p>Ce format de fichier n'est pas prévisualisable directement. <br> Téléchargez-le ou
                                ouvrez-le dans une application compatible.</p>
                        </div>
                    @endif
                </div>
                <aside id="doc-aside"
                    class="bg-gray-50 p-6 dark:bg-gray-700 rounded-br-lg border-l border-gray-200 dark:border-gray-600 space-y-3">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Informations sur le document</h2>
                    <ul class="mt-4 space-y-2 text-gray-600 dark:text-gray-400">
                        <li><strong>Titre :</strong> {{ $document->nom }}</li>
                        <li><strong>Type du fichier :</strong> {{ $document->type }}</li>
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
    <!-- PDF.js viewer (minimal) -->

    <script>
        (function() {
            'use strict';

            const USER_PERMISSION = '{{ $permission ?? 'N' }}'; // L = Lecture
            const IS_READONLY = USER_PERMISSION === 'L';

            if (!IS_READONLY) return;

            console.log('[🔒] Mode lecture seule activé');

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
                    (ctrl && shift && key === 'i'),
                    (ctrl && key === 'u'), // Source
                    (ctrl && key === 't'), // Nouvel onglet
                    (ctrl && key === 'f'), // Rechercher
                    (ctrl && key === 'h'), // Historique
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
                            content: "Impression désactivée - Document protégé";
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
                    `;
                    document.body.appendChild(alertDiv);
                }

                alertDiv.textContent = message;
                alertDiv.style.display = 'block';

                setTimeout(() => {
                    alertDiv.style.display = 'none';
                }, 3000);
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
