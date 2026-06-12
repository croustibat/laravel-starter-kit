<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">
        <div class="sm:flex sm:items-start sm:justify-between gap-6 mb-8">
            <div class="mb-5 sm:mb-0 max-w-3xl">
                <p class="text-sm font-semibold text-violet-600 dark:text-violet-400 mb-2">Veille</p>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Sources</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">
                    Votre matière première éditoriale : liens, articles, newsletters, podcasts ou études à transformer en angle, digest, article, audio ou vidéo.
                </p>
            </div>

            <a href="{{ route('items.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M7 2a1 1 0 0 1 2 0v5h5a1 1 0 1 1 0 2H9v5a1 1 0 1 1-2 0V9H2a1 1 0 1 1 0-2h5V2Z" />
                </svg>
                <span>Capturer un lien</span>
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.707-9.293a1 1 0 0 0-1.414-1.414L9 10.586 7.707 9.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($items->isEmpty() && ! request('search'))
            <div class="max-w-2xl m-auto mt-16">
                <div class="text-center px-4">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-300 mb-6">
                        <svg class="w-9 h-9 fill-current" viewBox="0 0 16 16">
                            <path d="M13.19 3.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m8.365-3.623 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                        </svg>
                    </div>
                    <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-2">Commencez par une source</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        Collez un lien, laissez Paperboy récupérer le contexte, puis ajoutez votre lecture avant de composer.
                    </p>
                    <a href="{{ route('items.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">Capturer un premier lien</a>
                </div>
            </div>
        @else
            <div class="sm:flex sm:justify-between sm:items-center gap-4 mb-6">
                <form class="relative mb-4 sm:mb-0" method="GET" action="{{ route('items.index') }}">
                    <label for="item-search" class="sr-only">Rechercher</label>
                    <input
                        id="item-search"
                        name="search"
                        class="form-input pl-9 w-full sm:w-80 bg-white dark:bg-gray-800"
                        type="search"
                        placeholder="Rechercher une source..."
                        value="{{ request('search') }}"
                    />
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Rechercher">
                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7ZM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5Z" />
                            <path d="m15.707 14.293-2.393-2.393a8.019 8.019 0 0 1-1.414 1.414l2.393 2.393a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414Z" />
                        </svg>
                    </button>
                </form>

                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center rounded-full bg-gray-100 dark:bg-gray-800 px-3 py-1">{{ $items->total() }} source(s)</span>
                    <a href="{{ route('briefs.index') }}" class="inline-flex items-center rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300 px-3 py-1">Briefs IA</a>
                </div>
            </div>

            @if($items->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">Aucune source ne correspond à votre recherche.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($items as $item)
                        <article class="bg-white dark:bg-gray-800 shadow-xs rounded-xl border border-gray-100 dark:border-gray-700/60 overflow-hidden">
                            <div class="p-5 md:p-6">
                                <div class="flex flex-col lg:flex-row lg:items-start gap-5">
                                    @if($item->image_url)
                                        <a href="{{ route('items.edit', $item) }}" class="block lg:w-44 shrink-0 aspect-video overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover" />
                                        </a>
                                    @else
                                        <a href="{{ route('items.edit', $item) }}" class="hidden lg:flex lg:w-20 h-20 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-400 dark:bg-gray-700 dark:text-gray-500">
                                            <svg class="w-7 h-7 fill-current" viewBox="0 0 16 16">
                                                <path d="M13.19 3.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m8.365-3.623 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                            </svg>
                                        </a>
                                    @endif

                                    <div class="min-w-0 grow">
                                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400 dark:text-gray-500 mb-2">
                                            <span class="font-mono">{{ parse_url($item->url, PHP_URL_HOST) }}</span>
                                            <span>·</span>
                                            <span>capturée {{ $item->created_at->diffForHumans() }}</span>
                                        </div>

                                        <a class="group" href="{{ route('items.edit', $item) }}">
                                            <h2 class="text-xl leading-snug font-semibold text-gray-900 dark:text-gray-100 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">{{ $item->title }}</h2>
                                        </a>

                                        @if($item->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ $item->description }}</p>
                                        @else
                                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Angle à préciser avant composition.</p>
                                        @endif

                                        <div class="mt-4 flex flex-wrap gap-2">
                                            @forelse($item->tags as $tag)
                                                <span class="text-xs inline-flex items-center font-medium bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300 rounded-full px-2.5 py-1">{{ $tag->name }}</span>
                                            @empty
                                                <span class="text-xs inline-flex items-center font-medium bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400 rounded-full px-2.5 py-1">Sans tag</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="lg:w-48 shrink-0 flex lg:flex-col gap-2">
                                        <a href="{{ route('items.edit', $item) }}" class="btn-sm justify-center bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">Annoter</a>
                                        <form method="POST" action="{{ route('items.start-digest', $item) }}">
                                            @csrf
                                            <button type="submit" class="btn-sm w-full justify-center bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300">Composer</button>
                                        </form>
                                        <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="btn-sm justify-center bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300">Ouvrir</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($items->hasPages())
                    <div class="mt-8">
                        {{ $items->links() }}
                    </div>
                @endif
            @endif
        @endif
    </div>
</x-app-layout>
