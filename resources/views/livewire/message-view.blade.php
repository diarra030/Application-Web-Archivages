<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div id="div1" style="display: block;" class="p-6">
        <!-- Titre principal -->
        <h1 class="text-2xl pt-6 font-bold text-center text-gray-800 dark:text-gray-200 mb-6">
            Messages reçus
        </h1>
        <div class="container mx-auto px-4 py-6">
            @if (count($taggedDocuments) > 0)
                <ul
                    class="max-w-3xl mx-auto divide-y divide-gray-200 dark:divide-gray-700 bg-white shadow rounded-lg dark:bg-gray-800">
                    @foreach ($taggedDocuments as $document)
                        @php
                            $tagger = \App\Models\User::find($document->pivot->tagger);
                        @endphp
                        <li>
                            <a href="{{ route('message.show', $document->pivot->id) }}"
                                class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                                <div class="flex items-center px-4 py-4 space-x-4 rtl:space-x-reverse sm:px-6">
                                    <!-- Indicateur de message -->
                                    @if ($document->pivot->new == true)
                                        <span class="w-2 h-2 me-2 bg-red-500 rounded-full"></span>
                                    @else
                                        <span class="w-2 h-2 me-2 bg-transparent"></span>
                                    @endif

                                    <!-- Avatar -->
                                    <div
                                        class="relative inline-flex items-center justify-center w-12 h-12 overflow-hidden bg-blue-100 rounded-full dark:bg-gray-600">
                                        <span class="font-medium text-gray-600 dark:text-gray-300">
                                            {{ $tagger->name[0] }}
                                        </span>
                                    </div>

                                    <!-- Contenu principal -->
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $tagger->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $tagger->email }} - {{ Str::limit($document->pivot->message, 10) }}...
                                        </p>
                                    </div>

                                    <!-- Date -->
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $document->pivot->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <h1 class="font-italic text-sm pt-6 font-bold text-center text-gray-600 dark:text-gray-200 mb-6">
                    Aucun message réçu
                </h1>
            @endif

        </div>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $taggedDocuments->links() }}
        </div>
    </div>

    <div id="div2" style="display: none;" class="p-6">
        <h1 class="text-2xl pt-6 font-bold text-center text-gray-800 dark:text-gray-200 mb-6">
            Messages envoyés
        </h1>
        <div class="container mx-auto px-4 py-6">
            @if (count($taggerDocuments) > 0)
                <ul
                    class="max-w-3xl mx-auto divide-y divide-gray-200 dark:divide-gray-700 bg-white shadow rounded-lg dark:bg-gray-800">
                    @foreach ($taggerDocuments as $document)
                        @foreach ($document->users as $user)
                            @php
                                $tagged = \App\Models\User::find($user->pivot->user_id);
                            @endphp
                            <li>
                                <a href="{{ route('message.showSend', $user->id) }}"
                                    class="block hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <div class="flex items-center px-4 py-4 space-x-4 rtl:space-x-reverse sm:px-6">
                                        <!-- Indicateur de message -->
                                        @if ($user->pivot->new == true)
                                            <span class="inline-block w-20 text-center py-5">
                                                <em class="font-italic text-xs text-gray-200">Envoyé...</em>
                                            </span>
                                        @else
                                            <span class="inline-block w-20 text-center">
                                                <em class="font-italic text-xs text-gray-200">Vu</em>
                                            </span>
                                        @endif


                                        <!-- Avatar -->
                                        <div
                                            class="relative inline-flex items-center justify-center w-12 h-12 overflow-hidden bg-blue-100 rounded-full dark:bg-gray-600">
                                            <span class="font-medium text-gray-600 dark:text-gray-300">
                                                {{ $tagged->name[0] }}
                                            </span>
                                        </div>

                                        <!-- Contenu principal -->
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                Vous à {{ $tagged->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                {{ $tagged->email }} - {{ Str::limit($user->pivot->message, 10) }}...
                                            </p>
                                        </div>

                                        <!-- Date -->
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $user->pivot->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            @else
                <h1 class="font-italic text-sm pt-6 font-bold text-center text-gray-600 dark:text-gray-200 mb-6">
                    Aucun message envoyé
                </h1>
            @endif
        </div>
        <!-- Pagination -->
        <div class="mt-4">
            {{ $taggerDocuments->links() }}
        </div>
    </div>

    {{-- Menu --}}
    <div class="py-12 pr-3 pl-3">
        <!-- drawer component -->
        <div id="drawer-disable-body-scrolling"
            class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-64 dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-disable-body-scrolling-label">
            <h5 id="drawer-disable-body-scrolling-label"
                class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>
            <button type="button" data-drawer-hide="drawer-disable-body-scrolling"
                aria-controls="drawer-disable-body-scrolling"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
            <div class="py-4 overflow-y-auto">
                <ul class="space-y-2 font-medium">
                    <!-- Message réçcu -->
                    <li>
                        <a onclick="showDiv('div1')" data-drawer-hide="drawer-disable-body-scrolling"
                            class="flex items-center p-2 text-blue-900 rounded-lg dark:text-white hover:bg-blue-200 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-blue-500 transition duration-75 group-hover:text-blue-900 dark:text-gray-400 dark:group-hover:text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Messages réçus</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="showDiv('div2')" data-drawer-hide="drawer-disable-body-scrolling"
                            class="flex items-center p-2 text-green-900 rounded-lg dark:text-white hover:bg-green-200 dark:hover:bg-gray-700 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 transition duration-75 group-hover:text-green-900 dark:text-gray-400 dark:group-hover:text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M14.516 6.743c-.41-.368-.443-1-.077-1.41a.99.99 0 0 1 1.405-.078l5.487 4.948.007.006A2.047 2.047 0 0 1 22 11.721a2.06 2.06 0 0 1-.662 1.51l-5.584 5.09a.99.99 0 0 1-1.404-.07 1.003 1.003 0 0 1 .068-1.412l5.578-5.082a.05.05 0 0 0 .015-.036.051.051 0 0 0-.015-.036l-5.48-4.942Zm-6.543 9.199v-.42a4.168 4.168 0 0 0-2.715 2.415c-.154.382-.44.695-.806.88a1.683 1.683 0 0 1-2.167-.571 1.705 1.705 0 0 1-.279-1.092V15.88c0-3.77 2.526-7.039 5.967-7.573V7.57a1.957 1.957 0 0 1 .993-1.838 1.931 1.931 0 0 1 2.153.184l5.08 4.248a.646.646 0 0 1 .012.011l.011.01a2.098 2.098 0 0 1 .703 1.57 2.108 2.108 0 0 1-.726 1.59l-5.08 4.25a1.933 1.933 0 0 1-2.929-.614 1.957 1.957 0 0 1-.217-1.04Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Message envoyer</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <script>
        function showDiv(divId) {
            const div1 = document.getElementById('div1');
            const div2 = document.getElementById('div2');

            if (divId === 'div1') {
                div1.style.display = 'block';
                div2.style.display = 'none';
            } else if (divId === 'div2') {
                div1.style.display = 'none';
                div2.style.display = 'block';
            }
        }
    </script>
</div>
