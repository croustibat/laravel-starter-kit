<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">
        <div class="sm:flex sm:items-start sm:justify-between gap-6 mb-8">
            <div class="mb-5 sm:mb-0 max-w-3xl">
                <p class="text-sm font-semibold text-violet-600 dark:text-violet-400 mb-2">Veille auto · IA</p>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Briefs</h1>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mt-3 leading-relaxed">
                    Décrivez votre veille une fois. Paperboy surveille vos thèmes, sélectionne les meilleures sources et pré-rédige un brouillon sourcé. Vous gardez la main sur l'angle, le format et la publication.
                </p>
            </div>

            <a href="{{ route('items.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M7 2a1 1 0 0 1 2 0v5h5a1 1 0 1 1 0 2H9v5a1 1 0 1 1-2 0V9H2a1 1 0 1 1 0-2h5V2Z" />
                </svg>
                <span>Capturer une source</span>
            </a>
        </div>

        <section class="bg-white dark:bg-gray-800 shadow-xs rounded-xl border border-violet-200 dark:border-violet-800/60 overflow-hidden mb-8">
            <div class="p-6 md:p-8">
                <div class="flex flex-col xl:flex-row xl:items-end gap-6">
                    <div class="grow">
                        <div class="flex items-center gap-3 mb-5">
                            <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-violet-100 text-violet-600 dark:bg-violet-900/40 dark:text-violet-300">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 16 16">
                                    <path d="M8 0a1 1 0 0 1 1 1v1.07a6.003 6.003 0 0 1 4.93 4.93H15a1 1 0 1 1 0 2h-1.07A6.003 6.003 0 0 1 9 13.93V15a1 1 0 1 1-2 0v-1.07A6.003 6.003 0 0 1 2.07 9H1a1 1 0 0 1 0-2h1.07A6.003 6.003 0 0 1 7 2.07V1a1 1 0 0 1 1-1Z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Générer un brouillon éditorial</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">À partir d'un brief enregistré, de mots-clés, ou des sources déjà capturées.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-5">
                            <div>
                                <label for="brief-topic" class="block text-xs font-semibold uppercase tracking-wide text-gray-400 mb-2">Brief</label>
                                <input id="brief-topic" class="form-input w-full" value="Signaux IA" readonly>
                            </div>
                            <div>
                                <label for="brief-period" class="block text-xs font-semibold uppercase tracking-wide text-gray-400 mb-2">Période</label>
                                <input id="brief-period" class="form-input w-full" value="7 derniers jours" readonly>
                            </div>
                            <div>
                                <label for="brief-format" class="block text-xs font-semibold uppercase tracking-wide text-gray-400 mb-2">Sortie</label>
                                <input id="brief-format" class="form-input w-full" value="Digest, article, audio ou vidéo" readonly>
                            </div>
                        </div>

                        <label for="brief-keywords" class="block text-xs font-semibold uppercase tracking-wide text-gray-400 mb-2">Mots-clés & angle</label>
                        <textarea id="brief-keywords" class="form-textarea w-full min-h-28" readonly>IA générative, agents, design produit, adoption réelle, sources citées</textarea>
                    </div>

                    <div class="xl:w-80 shrink-0">
                        <div class="rounded-xl bg-gray-50 dark:bg-gray-900/50 p-5 mb-4">
                            <div class="flex items-center justify-between text-sm mb-3">
                                <span class="text-gray-500 dark:text-gray-400">Sources disponibles</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">{{ $sourceCount }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Brouillons actifs</span>
                                <span class="font-bold text-gray-900 dark:text-gray-100">{{ $draftCount }}</span>
                            </div>
                        </div>

                        <button class="btn w-full justify-center bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white" type="button" disabled>
                            Générer le brouillon
                        </button>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-3">Prototype d'interface : la génération réelle arrivera après la consolidation des objets éditoriaux.</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-12 gap-6">
            <section class="col-span-full xl:col-span-7 bg-white dark:bg-gray-800 shadow-xs rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Sources candidates</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Les dernières captures que Paperboy pourrait proposer dans un brief.</p>
                </div>
                <div class="p-6">
                    @if($suggestedSources->isEmpty())
                        <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-6">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100">Aucune source à analyser</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Capturez quelques liens pour alimenter un premier brief automatique.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($suggestedSources as $source)
                                <a href="{{ route('items.edit', $source) }}" class="block rounded-lg border border-gray-200 dark:border-gray-700/60 p-4 hover:border-violet-300 dark:hover:border-violet-700 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <h3 class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ $source->title }}</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">{{ parse_url($source->url, PHP_URL_HOST) }}</p>
                                        </div>
                                        <span class="shrink-0 text-xs font-medium rounded-full bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300 px-2.5 py-1">Candidat</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section class="col-span-full xl:col-span-5 bg-white dark:bg-gray-800 shadow-xs rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Formats de sortie</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Le brief prépare une base, puis Paperboy l'adapte au canal.</p>
                </div>
                <div class="p-6 grid grid-cols-1 gap-3">
                    @foreach(['Digest texte', 'Article long', 'Script audio', 'Script vidéo', 'Posts sociaux'] as $format)
                        <div class="rounded-lg bg-gray-50 dark:bg-gray-900/50 p-4 flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $format }}</span>
                            <span class="text-xs text-gray-400 dark:text-gray-500">Bientôt</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
