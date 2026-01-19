<x-landing-layout>
    <x-slot name="title">{{ $digest->title }} - Paperboy</x-slot>
    <x-slot name="description">{{ $digest->items->isNotEmpty() ? Str::limit($digest->items->first()->description ?? $digest->items->first()->title, 150) : 'Digest publié sur Paperboy' }}</x-slot>

    <!-- Hero Section -->
    <div class="relative pt-24 pb-12 md:pt-32 md:pb-16 bg-gradient-to-br from-violet-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-900 dark:to-violet-900/20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-8">
                <!-- Published Badge -->
                <div class="inline-flex items-center gap-2 mb-4 text-xs font-medium bg-green-500/20 text-green-700 dark:text-green-400 rounded-full px-3 py-1.5">
                    <svg class="w-3 h-3" viewBox="0 0 12 12" fill="currentColor">
                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"/>
                    </svg>
                    <span>Publié {{ $digest->published_at->locale('fr')->isoFormat('LL') }}</span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-5xl font-display font-bold text-gray-900 dark:text-gray-100 mb-4 animate-on-scroll">
                    {{ $digest->title }}
                </h1>

                <!-- Meta -->
                <div class="flex items-center justify-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>{{ $digest->items->count() }} {{ Str::plural('article', $digest->items->count()) }}</span>
                    </div>
                    @if($digest->items->flatMap->tags->unique('id')->count() > 0)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span>{{ $digest->items->flatMap->tags->unique('id')->count() }} {{ Str::plural('tag', $digest->items->flatMap->tags->unique('id')->count()) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 md:py-16">
        @if($digest->items->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-t from-gray-200 to-gray-100 dark:from-gray-700 dark:to-gray-800 mb-4">
                    <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Aucun article</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ce digest ne contient pas encore d'articles.</p>
            </div>
        @else
            <!-- Items List -->
            <div class="space-y-6 stagger-children">
                @foreach($digest->items as $item)
                    <article class="group bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 rounded-xl overflow-hidden hover:border-violet-300 dark:hover:border-violet-600/50 hover:shadow-lg transition-all duration-300">
                        <div class="flex flex-col md:flex-row items-start gap-0">
                            <!-- Item Number Badge -->
                            <div class="flex-shrink-0 w-full md:w-14 flex items-center justify-center bg-gradient-to-br from-violet-500 to-violet-600 md:h-full md:min-h-[140px] py-3 md:py-0">
                                <span class="text-2xl md:text-xl font-bold text-white">{{ $loop->iteration }}</span>
                            </div>

                            <!-- Thumbnail (if exists) -->
                            @if(!empty($item->image_url))
                                <div class="flex-shrink-0 w-full md:w-40 h-48 md:h-full">
                                    <img
                                        src="{{ $item->image_url }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    />
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="flex-grow min-w-0 p-6">
                                <div class="flex flex-col gap-3">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0 flex-grow">
                                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors leading-tight">
                                                {{ $item->title }}
                                            </h2>
                                            @if($item->url)
                                                <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm text-violet-500 hover:text-violet-600 dark:text-violet-400 dark:hover:text-violet-300 mb-3 transition-colors group/link">
                                                    <svg class="w-4 h-4 mr-1.5 flex-shrink-0 group-hover/link:translate-x-0.5 transition-transform" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M6.5 3.5h-3a1 1 0 00-1 1v8a1 1 0 001 1h8a1 1 0 001-1v-3m-7-3l7-7m0 0h-5m5 0v5"/>
                                                    </svg>
                                                    <span class="truncate max-w-md">{{ parse_url($item->url, PHP_URL_HOST) }}</span>
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Tags -->
                                        @if($item->tags->isNotEmpty())
                                            <div class="flex flex-wrap gap-1.5 flex-shrink-0">
                                                @foreach($item->tags as $tag)
                                                    <span class="text-xs inline-flex font-medium bg-violet-500/20 text-violet-700 dark:text-violet-300 rounded-full px-2.5 py-1 whitespace-nowrap">
                                                        {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    @if($item->description)
                                        <p class="text-base text-gray-600 dark:text-gray-400 leading-relaxed">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <!-- Footer CTA -->
        <div class="mt-16 pt-12 border-t border-gray-200 dark:border-gray-700/60">
            <div class="text-center bg-gradient-to-r from-violet-50 to-indigo-50 dark:from-violet-900/20 dark:to-indigo-900/20 rounded-xl p-8 md:p-12">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-violet-500/20 mb-4">
                    <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor">
                        <path d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-display font-bold text-gray-900 dark:text-gray-100 mb-3">
                    Créez vos propres digests
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-xl mx-auto">
                    Avec Paperboy, collectez, organisez et partagez votre veille sous forme de digests attractifs sur LinkedIn, X et par newsletter.
                </p>
                <a href="{{ route('landing') }}" class="inline-flex items-center justify-center btn bg-violet-500 hover:bg-violet-600 text-white px-6 py-3 rounded-lg transition btn-glow">
                    <span>Découvrir Paperboy</span>
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6.5 3.5h-3a1 1 0 00-1 1v8a1 1 0 001 1h8a1 1 0 001-1v-3m-7-3l7-7m0 0h-5m5 0v5"/>
                    </svg>
                </a>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-4">
                    Propulsé par <a href="{{ route('landing') }}" class="text-violet-600 dark:text-violet-400 hover:underline">Paperboy</a>
                </p>
            </div>
        </div>
    </div>
</x-landing-layout>
