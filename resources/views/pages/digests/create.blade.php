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
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Create New Digest</h1>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
            <div class="p-6">
                <form method="POST" action="{{ route('digests.store') }}">
                    @csrf

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
                            value="{{ old('title') }}"
                            required
                        />
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Give your digest a memorable name that describes its content.
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700/60">
                        <a href="{{ route('digests.index') }}" class="btn border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300">
                            Cancel
                        </a>
                        <button type="submit" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                            Create Digest
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
