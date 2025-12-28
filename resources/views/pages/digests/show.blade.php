<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <a href="{{ route('digests.index') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                        <path d="M6.6 13.4L1.2 8l5.4-5.4 1.4 1.4L4 8l4 4-1.4 1.4z"/>
                    </svg>
                </a>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">{{ $digest->title }}</h1>
            </div>
            <div class="flex items-center gap-4">
                @if($digest->status === 'published')
                    <div class="text-xs inline-flex font-medium bg-green-500/20 text-green-700 dark:text-green-400 rounded-full text-center px-2.5 py-1">Published</div>
                @else
                    <div class="text-xs inline-flex font-medium bg-gray-500/20 text-gray-600 dark:text-gray-400 rounded-full text-center px-2.5 py-1">Draft</div>
                @endif
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    @if($digest->published_at)
                        Published {{ $digest->published_at->diffForHumans() }}
                    @else
                        Created {{ $digest->created_at->diffForHumans() }}
                    @endif
                </span>
                <a href="{{ route('digests.edit', $digest) }}" class="btn btn-sm bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="w-4 h-4 fill-current shrink-0 mr-1" viewBox="0 0 16 16">
                        <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-full sm:col-span-6 xl:col-span-3">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-violet-500/20 mr-3">
                            <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $digest->items->count() }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Items</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full sm:col-span-6 xl:col-span-3">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-sky-500/20 mr-3">
                            <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            @php
                                $uniqueTags = $digest->items->flatMap->tags->unique('id');
                            @endphp
                            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $uniqueTags->count() }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Unique Tags</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full sm:col-span-6 xl:col-span-3">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-amber-500/20 mr-3">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </div>
                        <div>
                            @php
                                $itemsWithUrls = $digest->items->filter(fn($item) => !empty($item->url))->count();
                            @endphp
                            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $itemsWithUrls }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">External Links</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full sm:col-span-6 xl:col-span-3">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl p-5">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-emerald-500/20 mr-3">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $digest->socialPosts->count() }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Social Posts</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items List -->
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Digest Content</h2>
            </header>
            <div class="p-6">
                @if($digest->items->isEmpty())
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">No items yet</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">This digest doesn't have any items. Add some content to get started.</p>
                        <a href="{{ route('digests.edit', $digest) }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                            Add Items
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($digest->items as $item)
                            <div class="border border-gray-200 dark:border-gray-700/60 rounded-xl p-5 hover:border-gray-300 dark:hover:border-gray-600 transition-colors">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-gradient-to-br from-violet-500 to-violet-600 rounded-lg text-white font-semibold">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="min-w-0">
                                                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-1">{{ $item->title }}</h3>
                                                @if($item->url)
                                                    <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm text-violet-500 hover:text-violet-600 mb-2">
                                                        <span class="truncate max-w-md">{{ parse_url($item->url, PHP_URL_HOST) }}</span>
                                                        <svg class="w-3 h-3 ml-1 flex-shrink-0" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M3.5 3.5h5v5M8.5 3.5l-5 5"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                            @if($item->tags->isNotEmpty())
                                                <div class="flex flex-wrap gap-1 flex-shrink-0">
                                                    @foreach($item->tags as $tag)
                                                        <span class="text-xs inline-flex font-medium bg-violet-500/20 text-violet-700 dark:text-violet-300 rounded-full px-2.5 py-1">{{ $tag->name }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        @if($item->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        @if($digest->socialPosts->isNotEmpty())
        <!-- Social Posts Section -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Social Posts</h2>
            </header>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($digest->socialPosts as $post)
                        <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                            <div class="flex-shrink-0">
                                @if($post->platform === 'twitter')
                                    <div class="w-10 h-10 flex items-center justify-center bg-sky-500/20 rounded-full">
                                        <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                    </div>
                                @elseif($post->platform === 'linkedin')
                                    <div class="w-10 h-10 flex items-center justify-center bg-blue-500/20 rounded-full">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 flex items-center justify-center bg-gray-500/20 rounded-full">
                                        <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ $post->platform }}</span>
                                    @if($post->posted_at)
                                        <span class="text-xs text-gray-400">• Posted {{ $post->posted_at->diffForHumans() }}</span>
                                    @else
                                        <span class="text-xs inline-flex font-medium bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-full px-2 py-0.5">Scheduled</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $post->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
