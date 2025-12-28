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
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Edit Digest</h1>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <div class="p-6">
                <form method="POST" action="{{ route('digests.update', $digest) }}">
                    @csrf
                    @method('PUT')

                    <!-- Digest Title -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1 text-gray-600 dark:text-gray-300" for="title">
                            Digest Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="title"
                            name="title"
                            class="form-input w-full @error('title') border-red-500 @enderror"
                            type="text"
                            placeholder="e.g., Weekly Tech Links"
                            value="{{ old('title', $digest->title) }}"
                            required
                        />
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1 text-gray-600 dark:text-gray-300" for="status">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="form-select w-full @error('status') border-red-500 @enderror"
                            required
                        >
                            <option value="draft" {{ old('status', $digest->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $digest->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Publishing will make this digest visible to your audience.
                        </p>
                    </div>

                    <!-- Digest Info -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Digest Information</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Items:</span>
                                <span class="ml-2 text-gray-800 dark:text-gray-100 font-medium">{{ $digest->items->count() }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Created:</span>
                                <span class="ml-2 text-gray-800 dark:text-gray-100 font-medium">{{ $digest->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($digest->published_at)
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Published:</span>
                                <span class="ml-2 text-gray-800 dark:text-gray-100 font-medium">{{ $digest->published_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Slug:</span>
                                <span class="ml-2 text-gray-800 dark:text-gray-100 font-medium">{{ $digest->slug }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700/60">
                        <button
                            type="button"
                            onclick="document.getElementById('delete-form').submit()"
                            class="btn border-red-200 dark:border-red-800 hover:border-red-300 dark:hover:border-red-700 text-red-600 dark:text-red-400"
                        >
                            Delete Digest
                        </button>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('digests.index') }}" class="btn border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Delete Form (hidden) -->
                <form id="delete-form" method="POST" action="{{ route('digests.destroy', $digest) }}" class="hidden" onsubmit="return confirm('Are you sure you want to delete this digest? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <!-- Items Section -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Items in this Digest</h2>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $digest->items->count() }} items</span>
                </div>
            </header>
            <div class="p-6">
                @if($digest->items->isEmpty())
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No items in this digest yet.</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500">Add items from the admin panel to include content in this digest.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($digest->items as $item)
                            <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-full text-sm font-medium text-gray-600 dark:text-gray-300">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ $item->title }}</h4>
                                    @if($item->url)
                                        <a href="{{ $item->url }}" target="_blank" class="text-xs text-violet-500 hover:text-violet-600 truncate block">{{ $item->url }}</a>
                                    @endif
                                    @if($item->description)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $item->description }}</p>
                                    @endif
                                </div>
                                @if($item->tags->isNotEmpty())
                                    <div class="flex-shrink-0 flex gap-1">
                                        @foreach($item->tags->take(2) as $tag)
                                            <span class="text-xs inline-flex font-medium bg-violet-500/20 text-violet-700 dark:text-violet-300 rounded-full px-2 py-0.5">{{ $tag->name }}</span>
                                        @endforeach
                                        @if($item->tags->count() > 2)
                                            <span class="text-xs text-gray-400">+{{ $item->tags->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
