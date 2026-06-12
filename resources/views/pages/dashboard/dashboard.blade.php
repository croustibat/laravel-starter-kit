<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <div class="sm:flex sm:items-start sm:justify-between gap-6 mb-8">
            <div class="mb-5 sm:mb-0 max-w-3xl">
                <p class="text-sm font-semibold text-violet-600 dark:text-violet-400 mb-2">Atelier éditorial</p>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Transformez vos trouvailles en édition publiable.</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">
                    Paperboy doit vous ramener au geste essentiel : capturer une source, ajouter votre angle, composer un digest, puis publier une page et des textes prêts à partager.
                </p>
            </div>

            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('items.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M7 2a1 1 0 0 1 2 0v5h5a1 1 0 1 1 0 2H9v5a1 1 0 1 1-2 0V9H2a1 1 0 1 1 0-2h5V2Z" />
                    </svg>
                    <span>Capturer un lien</span>
                </a>
                <a href="{{ route('digests.create') }}" class="btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-700 dark:text-gray-300">
                    <span>Nouveau digest</span>
                </a>
                <a href="{{ route('briefs.index') }}" class="btn bg-violet-100 text-violet-700 hover:bg-violet-200 dark:bg-violet-900/40 dark:text-violet-300 dark:hover:bg-violet-900/60">
                    <span>Briefs IA</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Sources capturées</div>
                <div class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $stats['items'] }}</div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-500">Votre matière première éditoriale.</div>
            </div>
            <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Digests</div>
                <div class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $stats['digests'] }}</div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-500">{{ $stats['drafts'] }} brouillon(s) en cours.</div>
            </div>
            <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Publiés</div>
                <div class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['published'] }}</div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-500">Pages partageables déjà sorties.</div>
            </div>
            <div class="col-span-full sm:col-span-6 xl:col-span-3 bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Prochaine action</div>
                <div class="mt-2 text-lg font-bold text-gray-800 dark:text-gray-100">
                    @if($activeDigest)
                        Continuer le brouillon
                    @elseif($stats['items'] > 0)
                        Composer un digest
                    @else
                        Capturer un lien
                    @endif
                </div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-500">Un seul chemin, moins de friction.</div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <section class="col-span-full xl:col-span-7 bg-white dark:bg-gray-800 shadow-xs rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Table de montage</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Le digest actif doit devenir votre document de travail, pas une simple fiche.</p>
                </div>

                <div class="p-6">
                    @if($activeDigest)
                        <div class="rounded-xl border border-violet-200 dark:border-violet-800/60 bg-violet-50/70 dark:bg-violet-900/20 p-5 mb-6">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                                <div>
                                    <div class="text-xs font-semibold uppercase tracking-wide text-violet-600 dark:text-violet-400 mb-2">Brouillon actif</div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $activeDigest->title }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $activeDigest->items_count }} source(s) dans ce digest. Dernière mise à jour {{ $activeDigest->updated_at->diffForHumans() }}.</p>
                                </div>
                                <a href="{{ route('digests.edit', $activeDigest) }}" class="btn bg-violet-500 text-white hover:bg-violet-600 shrink-0">
                                    Continuer
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-6 mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Aucun brouillon actif</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-2xl">
                                Le meilleur prochain écran serait un composeur où l'on colle une URL, puis où Paperboy propose titre, image, résumé et angle personnel.
                            </p>
                            <div class="mt-5 flex flex-wrap gap-3">
                                <a href="{{ route('items.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">Capturer un premier lien</a>
                                <a href="{{ route('digests.create') }}" class="btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-700 dark:text-gray-300">Créer un digest</a>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4">
                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">1. Capture</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Collez l'URL et laissez Paperboy extraire le contexte utile.</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4">
                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">2. Angle</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Ajoutez pourquoi cette source mérite d'être partagée.</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4">
                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">3. Sorties</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Préparez une page, un article, un script audio ou une version vidéo.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-span-full xl:col-span-5 bg-white dark:bg-gray-800 shadow-xs rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Dernières sources</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">La matière brute à transformer cette semaine.</p>
                </div>

                <div class="p-6">
                    @if($recentItems->isEmpty())
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M6 12l4-4-4-4" />
                                    <path d="M2 8h8" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-100">Commencez avec un seul lien.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">C'est le plus petit test produit possible.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($recentItems as $item)
                                <a href="{{ route('items.edit', $item) }}" class="block rounded-lg border border-gray-200 dark:border-gray-700/60 p-4 hover:border-violet-300 dark:hover:border-violet-700 transition-colors">
                                    <div class="font-medium text-gray-800 dark:text-gray-100 truncate">{{ $item->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ parse_url($item->url, PHP_URL_HOST) }}</div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section class="col-span-full bg-white dark:bg-gray-800 shadow-xs rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-semibold text-gray-800 dark:text-gray-100">Digests récents</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ce qui est en cours ou déjà publiable.</p>
                    </div>
                    <a href="{{ route('digests.index') }}" class="btn-sm bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300">Tout voir</a>
                </div>

                <div class="p-6">
                    @if($recentDigests->isEmpty())
                        <div class="text-sm text-gray-500 dark:text-gray-400">Aucun digest pour l'instant. Créez une première édition dès que vous avez 3 bonnes sources.</div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($recentDigests as $digest)
                                <a href="{{ route('digests.edit', $digest) }}" class="rounded-xl border border-gray-200 dark:border-gray-700/60 p-5 hover:border-violet-300 dark:hover:border-violet-700 transition-colors">
                                    <div class="flex items-center justify-between gap-3 mb-4">
                                        <span class="text-xs font-medium rounded-full px-2.5 py-1 {{ $digest->status === 'published' ? 'bg-green-500/20 text-green-700 dark:text-green-400' : 'bg-gray-500/20 text-gray-600 dark:text-gray-400' }}">
                                            {{ $digest->status === 'published' ? 'Publié' : 'Brouillon' }}
                                        </span>
                                        <span class="text-xs text-gray-400">{{ $digest->items_count }} source(s)</span>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 line-clamp-2">{{ $digest->title }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Mis à jour {{ $digest->updated_at->diffForHumans() }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section class="col-span-full bg-white dark:bg-gray-800 shadow-xs rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-semibold text-gray-800 dark:text-gray-100">Veille auto · IA</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Un brief transforme un sujet récurrent en brouillon sourcé, puis vous choisissez l'angle et le format.</p>
                    </div>
                    <a href="{{ route('briefs.index') }}" class="btn-sm bg-violet-100 text-violet-700 hover:bg-violet-200 dark:bg-violet-900/40 dark:text-violet-300 dark:hover:bg-violet-900/60">Configurer</a>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-3">
                    @foreach(['Digest texte', 'Article long', 'Script audio', 'Script vidéo'] as $format)
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4">
                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">{{ $format }}</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Même veille, sortie adaptée au canal.</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

    </div>
</x-app-layout>
