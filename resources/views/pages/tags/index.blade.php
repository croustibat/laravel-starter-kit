<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">My Tags</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Organize your items with custom tags</p>
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

        <!-- Create tag form -->
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Create New Tag</h2>
            <form method="POST" action="{{ route('tags.store') }}" class="flex gap-3">
                @csrf
                <div class="flex-1">
                    <input
                        type="text"
                        name="name"
                        placeholder="Tag name..."
                        class="form-input w-full bg-white dark:bg-gray-900"
                        required
                        value="{{ old('name') }}"
                    />
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn bg-violet-600 hover:bg-violet-700 text-white">
                    <svg class="fill-current shrink-0 mr-2" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                    </svg>
                    Create Tag
                </button>
            </form>
        </div>

        @if($tags->isEmpty())
            <!-- Empty state -->
            <div class="max-w-2xl m-auto mt-16">
                <div class="text-center px-4">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-t from-gray-200 to-gray-100 dark:from-gray-700 dark:to-gray-800 mb-6">
                        <svg class="w-10 h-10 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl text-gray-800 dark:text-gray-100 font-bold mb-2">No tags yet</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        Create your first tag to start organizing your items. Tags help you categorize and find content quickly.
                    </p>
                </div>
            </div>
        @else
            <!-- Search -->
            <div class="mb-6">
                <form class="relative" method="GET" action="{{ route('tags.index') }}">
                    <label for="tag-search" class="sr-only">Search</label>
                    <input
                        id="tag-search"
                        name="search"
                        class="form-input pl-9 w-full sm:w-64 bg-white dark:bg-gray-800"
                        type="search"
                        placeholder="Search tags..."
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

            <!-- Tags grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($tags as $tag)
                    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-lg hover:shadow-md transition-shadow">
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-500/20 text-violet-700 dark:text-violet-400 rounded-full text-sm font-medium">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.568 1.5H2.75a1.25 1.25 0 00-1.25 1.25v2.818c0 .331.132.65.366.884l5.318 5.318a1.5 1.5 0 002.121 0l2.89-2.89a1.5 1.5 0 000-2.12L6.453 1.865a1.25 1.25 0 00-.885-.365z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h.007v.007H4V4z"/>
                                            </svg>
                                            {{ $tag->name }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $tag->items_count }} {{ Str::plural('item', $tag->items_count) }}
                                    </div>
                                </div>

                                <!-- Actions menu -->
                                <div class="relative inline-flex shrink-0" x-data="{ open: false }">
                                    <button
                                        class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 rounded-full p-1"
                                        :class="{ 'bg-gray-100 dark:bg-gray-700/60 text-gray-500 dark:text-gray-400': open }"
                                        @click.prevent="open = !open"
                                        :aria-expanded="open"
                                    >
                                        <span class="sr-only">Menu</span>
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <circle cx="10" cy="4" r="2" />
                                            <circle cx="10" cy="10" r="2" />
                                            <circle cx="10" cy="16" r="2" />
                                        </svg>
                                    </button>
                                    <div
                                        class="origin-top-right z-10 absolute top-full right-0 min-w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1"
                                        @click.outside="open = false"
                                        @keydown.escape.window="open = false"
                                        x-show="open"
                                        x-transition:enter="transition ease-out duration-200 transform"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-out duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        x-cloak
                                    >
                                        <ul>
                                            <li>
                                                <button
                                                    @click="open = false; $nextTick(() => { document.getElementById('edit-tag-{{ $tag->id }}').classList.remove('hidden'); })"
                                                    class="font-medium text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700/50 flex items-center gap-2 py-1.5 px-3 w-full text-left"
                                                >
                                                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                        <path d="M11.333 2A1.886 1.886 0 0114 4.667l-9 9-3.667 1 1-3.667 9-9z"/>
                                                    </svg>
                                                    Rename
                                                </button>
                                            </li>
                                            <li class="border-t border-gray-100 dark:border-gray-700/60 mt-1 pt-1">
                                                <form method="POST" action="{{ route('tags.destroy', $tag) }}" onsubmit="return confirm('Are you sure you want to delete this tag? It will be removed from all items.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-sm text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 flex items-center gap-2 py-1.5 px-3 w-full text-left">
                                                        <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                                            <path d="M2 4h12M5.333 4V2.667a1.333 1.333 0 011.334-1.334h2.666a1.333 1.333 0 011.334 1.334V4m2 0v9.333a1.333 1.333 0 01-1.334 1.334H4.667a1.333 1.333 0 01-1.334-1.334V4h9.334z"/>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit form (hidden by default) -->
                            <div id="edit-tag-{{ $tag->id }}" class="hidden mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/60">
                                <form method="POST" action="{{ route('tags.update', $tag) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex gap-2">
                                        <input
                                            type="text"
                                            name="name"
                                            value="{{ $tag->name }}"
                                            class="form-input flex-1 bg-white dark:bg-gray-900 text-sm"
                                            required
                                        />
                                        <button type="submit" class="btn-xs bg-violet-600 hover:bg-violet-700 text-white">
                                            Save
                                        </button>
                                        <button
                                            type="button"
                                            @click="document.getElementById('edit-tag-{{ $tag->id }}').classList.add('hidden')"
                                            class="btn-xs bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 text-gray-600 dark:text-gray-300"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($tags->hasPages())
                <div class="mt-8">
                    {{ $tags->links() }}
                </div>
            @endif
        @endif

    </div>
</x-app-layout>
