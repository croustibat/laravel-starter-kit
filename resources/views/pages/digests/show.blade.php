<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-start mb-8">
            <!-- Left: Title and meta -->
            <div class="mb-4 sm:mb-0">
                <div class="flex items-center gap-2 mb-3">
                    <a href="{{ route('digests.index') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L1.2 8l5.4-5.4 1.4 1.4L4 8l4 4-1.4 1.4z"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">{{ $digest->title }}</h1>
                </div>
                <div class="flex items-center gap-3 ml-6">
                    @if($digest->status === 'published')
                        <div class="text-xs inline-flex items-center gap-1 font-medium bg-green-500/20 text-green-700 dark:text-green-400 rounded-full text-center px-2.5 py-1">
                            <svg class="w-3 h-3" viewBox="0 0 12 12" fill="currentColor">
                                <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"/>
                            </svg>
                            Published
                        </div>
                    @else
                        <div class="text-xs inline-flex items-center gap-1 font-medium bg-gray-500/20 text-gray-600 dark:text-gray-400 rounded-full text-center px-2.5 py-1">
                            <svg class="w-3 h-3" viewBox="0 0 12 12" fill="currentColor">
                                <path d="M11 1H1a1 1 0 00-1 1v8a1 1 0 001 1h10a1 1 0 001-1V2a1 1 0 00-1-1zm-1 8H2V4h8v5z"/>
                            </svg>
                            Draft
                        </div>
                    @endif
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        @if($digest->published_at)
                            Published {{ $digest->published_at->diffForHumans() }}
                        @else
                            Created {{ $digest->created_at->diffForHumans() }}
                        @endif
                    </span>
                </div>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Delete Button -->
                <form method="POST" action="{{ route('digests.destroy', $digest) }}" onsubmit="return confirm('Are you sure you want to delete this digest? This action cannot be undone.')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn border-gray-200 dark:border-gray-700/60 hover:border-red-300 dark:hover:border-red-600 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                        <svg class="w-4 h-4 fill-current shrink-0 mr-1.5" viewBox="0 0 16 16">
                            <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/>
                        </svg>
                        <span>Delete</span>
                    </button>
                </form>

                <!-- Publish/Unpublish Button -->
                @if($digest->status === 'published')
                    <form method="POST" action="{{ route('digests.unpublish', $digest) }}" class="inline">
                        @csrf
                        <button type="submit" class="btn border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300">
                            <svg class="w-4 h-4 fill-current shrink-0 mr-1.5" viewBox="0 0 16 16">
                                <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z"/>
                            </svg>
                            <span>Unpublish</span>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('digests.publish', $digest) }}" class="inline">
                        @csrf
                        <button type="submit" class="btn bg-green-500 hover:bg-green-600 text-white">
                            <svg class="w-4 h-4 fill-current shrink-0 mr-1.5" viewBox="0 0 16 16">
                                <path d="M14.3 2.3L5 11.6 1.7 8.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l4 4c.2.2.4.3.7.3.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0z"/>
                            </svg>
                            <span>Publish</span>
                        </button>
                    </form>
                @endif

                <!-- Edit Button -->
                <a href="{{ route('digests.edit', $digest) }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="w-4 h-4 fill-current shrink-0 mr-1.5" viewBox="0 0 16 16">
                        <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"/>
                    </svg>
                    <span>Edit</span>
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
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Digest Content</h2>
                    <a href="{{ route('digests.edit', $digest) }}" class="btn-xs bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300">
                        <svg class="w-3 h-3 fill-current shrink-0 mr-1" viewBox="0 0 16 16">
                            <path d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"/>
                        </svg>
                        <span>Manage</span>
                    </a>
                </div>
            </header>
            <div class="p-6">
                @if($digest->items->isEmpty())
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-t from-gray-200 to-gray-100 dark:from-gray-700 dark:to-gray-800 mb-4">
                            <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">No items yet</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">This digest doesn't have any items. Add some content to get started.</p>
                        <a href="{{ route('digests.edit', $digest) }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                            <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                            </svg>
                            <span>Add Items</span>
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($digest->items as $item)
                            <div class="group border border-gray-200 dark:border-gray-700/60 rounded-xl overflow-hidden hover:border-violet-300 dark:hover:border-violet-600/50 hover:shadow-md transition-all duration-200">
                                <div class="flex items-start gap-0">
                                    <!-- Item Number Badge -->
                                    <div class="flex-shrink-0 w-14 flex items-center justify-center bg-gradient-to-br from-violet-500 to-violet-600 h-full min-h-[120px]">
                                        <span class="text-xl font-bold text-white">{{ $loop->iteration }}</span>
                                    </div>

                                    <!-- Thumbnail (if exists) -->
                                    @if(!empty($item->image_url))
                                        <div class="flex-shrink-0 w-32 h-full">
                                            <img
                                                src="{{ $item->image_url }}"
                                                alt="{{ $item->title }}"
                                                class="w-full h-full object-cover"
                                                loading="lazy"
                                            />
                                        </div>
                                    @endif

                                    <!-- Content -->
                                    <div class="flex-grow min-w-0 p-5">
                                        <div class="flex items-start justify-between gap-4 mb-2">
                                            <div class="min-w-0 flex-grow">
                                                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 mb-1 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">
                                                    {{ $item->title }}
                                                </h3>
                                                @if($item->url)
                                                    <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm text-violet-500 hover:text-violet-600 dark:text-violet-400 dark:hover:text-violet-300 mb-2 transition-colors">
                                                        <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
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
                                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-2">
                                                {{ $item->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Share Section -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Share</h2>
            </header>
            <div class="p-6">
                @if($digest->status === 'published')
                    <div class="flex items-start gap-4 p-4 bg-gradient-to-r from-violet-50 to-indigo-50 dark:from-violet-900/20 dark:to-indigo-900/20 border border-violet-200 dark:border-violet-800/50 rounded-xl">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 flex items-center justify-center bg-violet-500/20 rounded-full">
                                <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-grow min-w-0">
                            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-2">Public URL</h3>
                            <div class="flex items-center gap-2 mb-2">
                                <input
                                    type="text"
                                    value="{{ route('public.digest.show', $digest) }}"
                                    readonly
                                    class="form-input flex-grow text-sm bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700"
                                    id="share-url"
                                />
                                <button
                                    type="button"
                                    onclick="navigator.clipboard.writeText(document.getElementById('share-url').value); this.innerHTML = 'Copied!'; setTimeout(() => this.innerHTML = 'Copy', 2000)"
                                    class="btn-sm bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-700 dark:text-gray-300 whitespace-nowrap"
                                >
                                    Copy
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Share this link with your audience to view the digest.</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-3">
                            <svg class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-gray-100 mb-1">Publish to share</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Publish this digest to get a shareable public URL.</p>
                    </div>
                @endif
            </div>
        </div>

        @if($digest->socialPosts->isNotEmpty())
        <!-- Social Posts Section -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Social Posts</h2>
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2.5 py-1 rounded-full">
                        {{ $digest->socialPosts->count() }} {{ Str::plural('post', $digest->socialPosts->count()) }}
                    </span>
                </div>
            </header>
            <div class="p-6">
                <div class="grid gap-4">
                    @foreach($digest->socialPosts as $post)
                        <div class="group border border-gray-200 dark:border-gray-700/60 rounded-xl p-5 hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-sm transition-all duration-200">
                            <div class="flex items-start gap-4">
                                <!-- Platform Icon -->
                                <div class="flex-shrink-0">
                                    @if($post->platform === 'twitter')
                                        <div class="w-12 h-12 flex items-center justify-center bg-sky-500/20 rounded-xl">
                                            <svg class="w-6 h-6 text-sky-600 dark:text-sky-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                            </svg>
                                        </div>
                                    @elseif($post->platform === 'linkedin')
                                        <div class="w-12 h-12 flex items-center justify-center bg-blue-500/20 rounded-xl">
                                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 flex items-center justify-center bg-gray-500/20 rounded-xl">
                                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-grow min-w-0">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">{{ $post->platform }}</span>
                                        @if($post->posted_at)
                                            <span class="text-xs inline-flex items-center gap-1 font-medium bg-green-500/20 text-green-700 dark:text-green-400 rounded-full px-2.5 py-1">
                                                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="currentColor">
                                                    <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"/>
                                                </svg>
                                                Posted {{ $post->posted_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="text-xs inline-flex items-center gap-1 font-medium bg-amber-500/20 text-amber-700 dark:text-amber-300 rounded-full px-2.5 py-1">
                                                <svg class="w-3 h-3" viewBox="0 0 12 12" fill="currentColor">
                                                    <path d="M6 0C2.686 0 0 2.686 0 6s2.686 6 6 6 6-2.686 6-6-2.686-6-6-6zm0 10c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4zm1-5H5v3h2V5z"/>
                                                </svg>
                                                Scheduled
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{ $post->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
