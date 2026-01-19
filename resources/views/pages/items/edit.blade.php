<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <a href="{{ route('items.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Edit Item</h1>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Update your bookmark details</p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <div class="p-6">
                <form method="POST" action="{{ route('items.update', $item) }}">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-input w-full @error('title') border-red-300 @enderror"
                            placeholder="Enter item title"
                            value="{{ old('title', $item->title) }}"
                            required
                        />
                        @error('title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- URL -->
                    <div class="mb-6">
                        <label for="url" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                            URL <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="url"
                            id="url"
                            name="url"
                            class="form-input w-full @error('url') border-red-300 @enderror"
                            placeholder="https://example.com"
                            value="{{ old('url', $item->url) }}"
                            required
                        />
                        @error('url')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                            Description
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="form-textarea w-full @error('description') border-red-300 @enderror"
                            placeholder="Add a description (optional)"
                        >{{ old('description', $item->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image URL -->
                    <div class="mb-6">
                        <label for="image_url" class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                            Image URL
                        </label>
                        <input
                            type="url"
                            id="image_url"
                            name="image_url"
                            class="form-input w-full @error('image_url') border-red-300 @enderror"
                            placeholder="https://example.com/image.jpg (optional)"
                            value="{{ old('image_url', $item->image_url) }}"
                        />
                        @error('image_url')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                        @if($item->image_url)
                            <div class="mt-3">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Current image:</p>
                                <img src="{{ $item->image_url }}" alt="Current image" class="rounded-lg max-h-32 object-cover" />
                            </div>
                        @endif
                    </div>

                    <!-- Tags display (read-only for now) -->
                    @if($item->tags->isNotEmpty())
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-800 dark:text-gray-100 mb-2">
                                Tags
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($item->tags as $tag)
                                    <span class="text-xs inline-flex items-center font-medium bg-violet-500/20 text-violet-700 dark:text-violet-400 rounded-full px-2.5 py-1">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700/60">
                        <button
                            type="submit"
                            class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white"
                        >
                            Update Item
                        </button>
                        <a
                            href="{{ route('items.index') }}"
                            class="btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-600 dark:text-gray-300"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Metadata -->
        <div class="mt-6 text-xs text-gray-500 dark:text-gray-400">
            <p>Created {{ $item->created_at->format('M d, Y \a\t g:i A') }}</p>
            @if($item->updated_at->ne($item->created_at))
                <p>Last updated {{ $item->updated_at->diffForHumans() }}</p>
            @endif
        </div>

    </div>
</x-app-layout>
