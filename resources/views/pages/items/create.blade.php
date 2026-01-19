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
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Create Item</h1>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Add a new bookmark or link to your collection</p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <div class="p-6">
                <form method="POST" action="{{ route('items.store') }}">
                    @csrf

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
                            value="{{ old('title') }}"
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
                            value="{{ old('url') }}"
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
                        >{{ old('description') }}</textarea>
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
                            value="{{ old('image_url') }}"
                        />
                        @error('image_url')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700/60">
                        <button
                            type="submit"
                            class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white"
                        >
                            Create Item
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

    </div>
</x-app-layout>
