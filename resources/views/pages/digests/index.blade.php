<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">
        <div class="sm:flex sm:items-start sm:justify-between gap-6 mb-8">
            <div class="mb-5 sm:mb-0 max-w-3xl">
                <p class="text-sm font-semibold text-violet-600 dark:text-violet-400 mb-2">Composition</p>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Digests</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">
                    Assemblez vos sources, clarifiez l'angle et préparez les sorties : page publique, newsletter, article long, audio ou vidéo.
                </p>
            </div>

            <a href="{{ route('digests.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M7 2a1 1 0 0 1 2 0v5h5a1 1 0 1 1 0 2H9v5a1 1 0 1 1-2 0V9H2a1 1 0 1 1 0-2h5V2Z" />
                </svg>
                <span>Nouveau digest</span>
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

        @if($digests->isEmpty() && ! request('search') && ! request('status'))
            <div class="max-w-2xl m-auto mt-16">
                <div class="text-center px-4">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-300 mb-6">
                        <svg class="w-9 h-9 fill-current" viewBox="0 0 16 16">
                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm0 14H4V2h8v12ZM5 4h6v2H5V4Zm0 4h6v2H5V8Zm0 4h4v2H5v-2Z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-2">Aucun digest pour l'instant</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        Dès que vous avez quelques sources, créez une édition et donnez-lui un angle clair.
                    </p>
                    <a href="{{ route('digests.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">Créer une première édition</a>
                </div>
            </div>
        @else
            <div class="sm:flex sm:justify-between sm:items-center gap-4 mb-6">
                <form class="relative mb-4 sm:mb-0" method="GET" action="{{ route('digests.index') }}">
                    <label for="digest-search" class="sr-only">Rechercher</label>
                    <input
                        id="digest-search"
                        name="search"
                        class="form-input pl-9 w-full sm:w-80 bg-white dark:bg-gray-800"
                        type="search"
                        placeholder="Rechercher un digest..."
                        value="{{ request('search') }}"
                    />
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Rechercher">
                        <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7ZM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5Z" />
                            <path d="m15.707 14.293-2.393-2.393a8.019 8.019 0 0 1-1.414 1.414l2.393 2.393a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414Z" />
                        </svg>
                    </button>
                </form>

                <div class="flex items-center gap-2 overflow-x-auto">
                    <a href="{{ route('digests.index') }}" class="btn-sm px-3 py-1.5 rounded-lg text-sm font-medium transition {{ ! request('status') ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-800' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">Tous</a>
                    <a href="{{ route('digests.index', ['status' => 'draft']) }}" class="btn-sm px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('status') === 'draft' ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-800' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">Brouillons</a>
                    <a href="{{ route('digests.index', ['status' => 'published']) }}" class="btn-sm px-3 py-1.5 rounded-lg text-sm font-medium transition {{ request('status') === 'published' ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-800' : 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 text-gray-600 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600' }}">Publiés</a>
                </div>
            </div>

            @if($digests->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">Aucun digest ne correspond à ces critères.</p>
                </div>
            @else
                <div class="grid grid-cols-12 gap-6">
                    @foreach($digests as $digest)
                        <article class="col-span-full xl:col-span-6 bg-white dark:bg-gray-800 shadow-xs rounded-xl border border-gray-100 dark:border-gray-700/60 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4 mb-5">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="text-xs inline-flex items-center gap-1 font-medium rounded-full px-2.5 py-1 {{ $digest->status === 'published' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ $digest->status === 'published' ? 'Publié' : 'Brouillon' }}
                                            </span>
                                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $digest->items->count() }} source(s)</span>
                                        </div>
                                        <a class="group" href="{{ route('digests.edit', $digest) }}">
                                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">{{ $digest->title }}</h2>
                                        </a>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                            @if($digest->published_at)
                                                Publié {{ $digest->published_at->diffForHumans() }}
                                            @else
                                                Mis à jour {{ $digest->updated_at->diffForHumans() }}
                                            @endif
                                        </p>
                                    </div>

                                    <div class="relative inline-flex" x-data="{ open: false }">
                                        <button class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 rounded-full p-1" :class="{ 'bg-gray-100 dark:bg-gray-700/60 text-gray-500 dark:text-gray-400': open }" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                                            <span class="sr-only">Menu</span>
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <circle cx="10" cy="4" r="2" />
                                                <circle cx="10" cy="10" r="2" />
                                                <circle cx="10" cy="16" r="2" />
                                            </svg>
                                        </button>
                                        <div class="origin-top-right z-10 absolute top-full right-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1" @click.outside="open = false" @keydown.escape.window="open = false" x-show="open" x-transition x-cloak>
                                            <ul>
                                                <li>
                                                    <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 flex items-center gap-2 py-1.5 px-3" href="{{ route('digests.show', $digest) }}">Aperçu</a>
                                                </li>
                                                <li>
                                                    <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 flex items-center gap-2 py-1.5 px-3" href="{{ route('digests.edit', $digest) }}">Composer</a>
                                                </li>
                                                <li class="border-t border-gray-100 dark:border-gray-700/60 mt-1 pt-1">
                                                    <form method="POST" action="{{ route('digests.destroy', $digest) }}" onsubmit="return confirm('Supprimer ce digest ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="font-medium text-sm text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 flex items-center gap-2 py-1.5 px-3 w-full text-left">Supprimer</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4 mb-5">
                                    <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wide text-gray-400 dark:text-gray-500 mb-3">
                                        <span>Sommaire</span>
                                        <span>{{ $digest->items->count() }} source(s)</span>
                                    </div>
                                    @if($digest->items->isEmpty())
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Ajoutez des sources pour rendre cette édition publiable.</p>
                                    @else
                                        <div class="space-y-2">
                                            @foreach($digest->items->take(3) as $item)
                                                <div class="flex items-start gap-3 text-sm">
                                                    <span class="mt-1 h-1.5 w-1.5 rounded-full bg-violet-400 shrink-0"></span>
                                                    <span class="text-gray-700 dark:text-gray-300 line-clamp-1">{{ $item->title }}</span>
                                                </div>
                                            @endforeach
                                            @if($digest->items->count() > 3)
                                                <p class="text-xs text-gray-400 dark:text-gray-500">+ {{ $digest->items->count() - 3 }} autre(s)</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('digests.edit', $digest) }}" class="btn-sm bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">Composer</a>
                                    <a href="{{ route('digests.show', $digest) }}" class="btn-sm bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300">Aperçu</a>
                                    @if($digest->status === 'published')
                                        <a href="{{ route('public.digest.show', $digest) }}" class="btn-sm bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300">Page publique</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($digests->hasPages())
                    <div class="mt-8">
                        {{ $digests->links() }}
                    </div>
                @endif
            @endif
        @endif
    </div>
</x-app-layout>
