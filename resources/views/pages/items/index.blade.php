<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">My Items</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your bookmarks and saved links</p>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('items.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                    <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    <span>New Item</span>
                </a>
            </div>

        </div>

        <!-- Success message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($items->isEmpty() && !request('search'))
            <!-- Empty state -->
            <div class="max-w-2xl m-auto mt-16">
                <div class="text-center px-4">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-t from-gray-200 to-gray-100 dark:from-gray-700 dark:to-gray-800 mb-6">
                        <svg class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-2">No items yet</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        Start saving links and bookmarks to build your collection. Items can be organized into digests for easy sharing.
                    </p>
                    <a href="{{ route('items.create') }}" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                        <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        Create Your First Item
                    </a>
                </div>
            </div>
        @else
            <!-- Search -->
            <div class="sm:flex sm:justify-between sm:items-center mb-6">
                <div class="mb-4 sm:mb-0">
                    <form class="relative" method="GET" action="{{ route('items.index') }}">
                        <label for="item-search" class="sr-only">Search</label>
                        <input
                            id="item-search"
                            name="search"
                            class="form-input pl-9 w-full sm:w-64 bg-white dark:bg-gray-800"
                            type="search"
                            placeholder="Search items…"
                            value="{{ request('search') }}"
                        />
                        <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                            <svg class="shrink-0 fill-current text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400 ml-3 mr-2" width="16" height="16" viewBox="0 0 16 16">
                                <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                                <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            @if($items->isEmpty())
                <!-- No search results -->
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">No items found matching your search.</p>
                </div>
            @else
                <!-- Items grid -->
                <div class="grid grid-cols-12 gap-6">
                    @foreach($items as $item)
                        <div class="col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl hover:shadow-md transition-shadow">
                            <div class="flex flex-col h-full">
                                <!-- Card header with gradient accent -->
                                <div class="h-1 rounded-t-xl bg-gradient-to-r from-violet-400 to-violet-500"></div>

                                <!-- Image if available -->
                                @if($item->image_url)
                                    <div class="aspect-video overflow-hidden">
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover" />
                                    </div>
                                @endif

                                <div class="flex flex-col h-full p-5">
                                    <header>
                                        <div class="flex items-start justify-between mb-3">
                                            <!-- Tags -->
                                            <div class="flex flex-wrap gap-1.5">
                                                @forelse($item->tags as $tag)
                                                    <span class="text-xs inline-flex items-center font-medium bg-violet-500/20 text-violet-700 dark:text-violet-400 rounded-full px-2.5 py-1">
                                                        {{ $tag->name }}
                                                    </span>
                                                @empty
                                                    <span class="text-xs inline-flex items-center font-medium bg-gray-500/20 text-gray-600 dark:text-gray-400 rounded-full px-2.5 py-1">
                                                        Untagged
                                                    </span>
                                                @endforelse
                                            </div>

                                            <!-- Menu button -->
                                            <div class="relative inline-flex" x-data="{ open: false }">
                                                <button class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 rounded-full p-1" :class="{ 'bg-gray-100 dark:bg-gray-700/60 text-gray-500 dark:text-gray-400': open }" aria-haspopup="true" @click.prevent="open = !open" :aria-expanded="open">
                                                    <span class="sr-only">Menu</span>
                                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                        <circle cx="10" cy="4" r="2" />
                                                        <circle cx="10" cy="10" r="2" />
                                                        <circle cx="10" cy="16" r="2" />
                                                    </svg>
                                                </button>
                                                <div class="origin-top-right z-10 absolute top-full right-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1" @click.outside="open = false" @keydown.escape.window="open = false" x-show="open" x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                                                    <ul>
                                                        <li>
                                                            <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 flex items-center gap-2 py-1.5 px-3" href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                                                                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 12L10 8L6 4"/><path d="M10 2L14 2L14 6"/><path d="M14 2L8 8"/></svg>
                                                                Visit Link
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 flex items-center gap-2 py-1.5 px-3" href="{{ route('items.edit', $item) }}">
                                                                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11.333 2A1.886 1.886 0 0114 4.667l-9 9-3.667 1 1-3.667 9-9z"/></svg>
                                                                Edit
                                                            </a>
                                                        </li>
                                                        <li class="border-t border-gray-100 dark:border-gray-700/60 mt-1 pt-1">
                                                            <form method="POST" action="{{ route('items.destroy', $item) }}" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="font-medium text-sm text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 flex items-center gap-2 py-1.5 px-3 w-full text-left">
                                                                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 4h12M5.333 4V2.667a1.333 1.333 0 011.334-1.334h2.666a1.333 1.333 0 011.334 1.334V4m2 0v9.333a1.333 1.333 0 01-1.334 1.334H4.667a1.333 1.333 0 01-1.334-1.334V4h9.334z"/></svg>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </header>

                                    <div class="grow">
                                        <a class="group block" href="{{ route('items.edit', $item) }}">
                                            <h2 class="text-lg leading-snug font-semibold text-gray-800 dark:text-gray-100 group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors mb-2">{{ $item->title }}</h2>
                                        </a>

                                        @if($item->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                                {{ $item->description }}
                                            </p>
                                        @endif

                                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                                            </svg>
                                            <span class="truncate">{{ parse_url($item->url, PHP_URL_HOST) }}</span>
                                        </div>
                                    </div>

                                    <footer class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/60">
                                        <div class="flex items-center justify-between">
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                Added {{ $item->created_at->diffForHumans() }}
                                            </div>
                                            <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="btn-xs bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300">
                                                Visit
                                            </a>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                    <div class="mt-8">
                        {{ $items->links() }}
                    </div>
                @endif
            @endif
        @endif

    </div>
</x-app-layout>
