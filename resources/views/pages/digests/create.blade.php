<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="mb-8">
            <!-- Breadcrumb -->
            <div class="mb-3">
                <nav class="flex items-center gap-2 text-sm">
                    <a href="{{ route('digests.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition">
                        Digests
                    </a>
                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-600" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M6.6 13.4L1.2 8l5.4-5.4 1.4 1.4L4 8l4 4z" transform="rotate(180 8 8)"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-100 font-medium">Create</span>
                </nav>
            </div>

            <!-- Title & Description -->
            <div>
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Create New Digest</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Start by giving your digest a name. You'll be able to add items and customize it after creation.</p>
            </div>
        </div>

        <!-- Main form card -->
        <div class="max-w-3xl">
            <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('digests.store') }}">
                        @csrf

                        <!-- Digest Title -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300" for="title">
                                Digest Title <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="title"
                                name="title"
                                class="form-input w-full @error('title') border-red-500 @enderror"
                                type="text"
                                placeholder="e.g., Weekly Tech Links, Monthly Product Updates..."
                                value="{{ old('title') }}"
                                required
                                autofocus
                            />
                            @error('title')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Choose a clear, descriptive name that reflects the content you'll be curating.
                            </p>
                        </div>

                        <!-- Info callout -->
                        <div class="mb-6 p-4 bg-violet-50 dark:bg-violet-900/20 border border-violet-100 dark:border-violet-800/40 rounded-lg">
                            <div class="flex gap-3">
                                <svg class="w-5 h-5 text-violet-600 dark:text-violet-400 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-violet-900 dark:text-violet-100 mb-1">What happens next?</h3>
                                    <p class="text-sm text-violet-700 dark:text-violet-300">
                                        After creating your digest, you'll be taken to the editor where you can add items, organize content, and customize your digest before publishing.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-5 border-t border-gray-200 dark:border-gray-700/60">
                            <a href="{{ route('digests.index') }}" class="btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <svg class="w-4 h-4 mr-2" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M10 12L6 8l4-4"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                                <svg class="w-4 h-4 mr-2" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                                </svg>
                                Create Digest
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
