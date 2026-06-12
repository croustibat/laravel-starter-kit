<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">

        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
                <p class="text-sm font-semibold text-violet-600 dark:text-violet-400">Capture</p>
            </div>
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Collez une URL, Paperboy prépare la source.</h1>
            <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 mt-3 max-w-2xl">
                Commencez par le lien. Le titre, le résumé et l’image peuvent être remplis automatiquement, puis vous gardez la main pour donner votre angle.
            </p>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-full lg:col-span-8">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                    <div class="p-6">
                        <form method="POST" action="{{ route('items.store') }}">
                            @csrf

                            <div class="mb-6">
                                <label for="url" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                                    Lien à capturer <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="url"
                                    id="url"
                                    name="url"
                                    class="form-input w-full text-base @error('url') border-red-300 @enderror"
                                    placeholder="https://example.com/article-a-partager"
                                    value="{{ old('url') }}"
                                    required
                                    autofocus
                                />
                                @error('url')
                                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Si vous ne renseignez rien d’autre, Paperboy tentera d’extraire les métadonnées de la page.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="md:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                                        Titre éditorial
                                    </label>
                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        class="form-input w-full @error('title') border-red-300 @enderror"
                                        placeholder="Laissez vide pour utiliser le titre de la page"
                                        value="{{ old('title') }}"
                                    />
                                    @error('title')
                                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                                        Note ou résumé
                                    </label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="5"
                                        class="form-textarea w-full @error('description') border-red-300 @enderror"
                                        placeholder="Pourquoi cette source est intéressante ? Quelle idée voulez-vous reprendre dans votre digest ?"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="image_url" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                                        Image
                                    </label>
                                    <input
                                        type="url"
                                        id="image_url"
                                        name="image_url"
                                        class="form-input w-full @error('image_url') border-red-300 @enderror"
                                        placeholder="Laissez vide pour utiliser l’image Open Graph"
                                        value="{{ old('image_url') }}"
                                    />
                                    @error('image_url')
                                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700/60">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Après capture, vous arriverez sur la source pour l’affiner avant de l’ajouter à un digest.</p>
                                <div class="flex gap-3">
                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300"
                                    >
                                        Annuler
                                    </a>
                                    <button
                                        type="submit"
                                        class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white"
                                    >
                                        Capturer la source
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <aside class="col-span-full lg:col-span-4">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-6">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Ce que Paperboy prépare</h2>
                    <div class="mt-5 space-y-4">
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-violet-500/20 text-violet-600 dark:text-violet-400 flex items-center justify-center text-sm font-bold shrink-0">1</div>
                            <div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100">Une source propre</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Titre, URL, résumé et image réunis au même endroit.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-violet-500/20 text-violet-600 dark:text-violet-400 flex items-center justify-center text-sm font-bold shrink-0">2</div>
                            <div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100">Votre angle</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">La note devient la matière qui donnera de la valeur au digest.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-violet-500/20 text-violet-600 dark:text-violet-400 flex items-center justify-center text-sm font-bold shrink-0">3</div>
                            <div>
                                <div class="text-sm font-medium text-gray-800 dark:text-gray-100">Une prochaine édition</div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Quand vous avez quelques bonnes sources, composez le digest.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

    </div>
</x-app-layout>
