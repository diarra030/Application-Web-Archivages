<div>
    <div wire:poll.20s >
        {{-- Nothing in the world is as soft and yielding as water. --}}

        @if (count($taggedDocuments) > 0)
            @foreach ($taggedDocuments as $document)
                @php
                    $tagger = \App\Models\User::find($document->pivot->tagger);
                @endphp
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    <a href="{{ route('message.show', $document->pivot->id) }}"
                        class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="flex-shrink-0">
                            <div
                                class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-blue-100 rounded-full dark:bg-gray-600">
                                <span class="font-medium text-gray-600 dark:text-gray-300"> {{ $tagger->name[0] }}
                                </span>
                            </div>
                            <div
                                class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-green-400 border border-white rounded-full dark:border-gray-800">
                                <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 18">
                                    <path
                                        d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z" />
                                </svg>
                            </div>
                        </div>
                        <div class="w-full ps-3">
                            <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $tagger->name }}</span>
                                vous a
                                identifié sur un document : {{ Str::limit($document->nom, 8) }}...<span
                                    class="font-medium text-blue-500" href="#"> {{ $user->email }} </span>
                                {{ Str::limit($document->pivot->message, 5) }}... </div>
                            <div class="text-xs text-blue-600 dark:text-blue-500">
                                {{ $document->pivot->created_at->diffForHumans() }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                <h1 class="text-center text-gray-800 dark:text-gray-200 mb-6">
                    Aucun message reçu non lu
                </h1>
            </div>
        @endif
    </div>

</div>
