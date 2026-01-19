<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-[96rem] mx-auto">

        <!-- Page header -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title with back button -->
            <div class="mb-4 sm:mb-0">
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('digests.index') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 16 16">
                            <path d="M6.6 13.4L1.2 8l5.4-5.4 1.4 1.4L4 8l4 4-1.4 1.4z"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Edit Digest</h1>
                    <!-- Status badge -->
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
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Update your digest details and manage items</p>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <a href="{{ route('digests.show', $digest) }}" class="btn border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300 transition-all hover:shadow-sm">
                    <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                        <path d="M8 3C3 3 1 8 1 8s2 5 7 5 7-5 7-5-2-5-7-5zm0 8a3 3 0 110-6 3 3 0 010 6z"/>
                        <circle cx="8" cy="8" r="1.5"/>
                    </svg>
                    <span>View</span>
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

        <!-- Main content grid -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Main form section -->
            <div class="col-span-full xl:col-span-8">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                    <div class="p-6">
                        <form method="POST" action="{{ route('digests.update', $digest) }}">
                            @csrf
                            @method('PUT')

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
                                    placeholder="e.g., Weekly Tech Links"
                                    value="{{ old('title', $digest->title) }}"
                                    required
                                />
                                @error('title')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300" for="status">
                                    Publication Status <span class="text-red-500">*</span>
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
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    Publishing will make this digest visible to your audience.
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700/60">
                                <button
                                    type="button"
                                    onclick="document.getElementById('delete-form').submit()"
                                    class="btn border-red-200 dark:border-red-800 hover:border-red-300 dark:hover:border-red-700 text-red-600 dark:text-red-400 transition-all hover:shadow-sm"
                                >
                                    <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                                        <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/>
                                    </svg>
                                    Delete Digest
                                </button>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('digests.index') }}" class="btn border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300 transition-all hover:shadow-sm">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white transition-all hover:shadow-md">
                                        <svg class="w-4 h-4 fill-current shrink-0 mr-2" viewBox="0 0 16 16">
                                            <path d="M14.3 2.3L5 11.6 1.7 8.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4l4 4c.2.2.4.3.7.3.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4-.4-.4-1-.4-1.4 0z"/>
                                        </svg>
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
            </div>

            <!-- Sidebar: Digest Info -->
            <div class="col-span-full xl:col-span-4">
                <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
                    <div class="p-6">
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100 mb-4 uppercase tracking-wide">Digest Information</h3>
                        <div class="space-y-4">
                            <!-- Items count -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700/60">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M2 4h12M2 8h12M2 12h8"/>
                                    </svg>
                                    <span class="text-sm font-medium">Items</span>
                                </div>
                                <span class="text-lg font-bold text-violet-600 dark:text-violet-400">{{ $digest->items->count() }}</span>
                            </div>

                            <!-- Created date -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700/60">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="8" cy="8" r="6.5"/>
                                        <path d="M8 4v4l2 2"/>
                                    </svg>
                                    <span class="text-sm font-medium">Created</span>
                                </div>
                                <span class="text-sm text-gray-800 dark:text-gray-100 font-medium">{{ $digest->created_at->format('M d, Y') }}</span>
                            </div>

                            <!-- Updated date -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700/60">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M8 1v3M8 12v3M3.93 3.93l2.12 2.12M9.95 9.95l2.12 2.12M1 8h3M12 8h3M3.93 12.07l2.12-2.12M9.95 6.05l2.12-2.12"/>
                                    </svg>
                                    <span class="text-sm font-medium">Updated</span>
                                </div>
                                <span class="text-sm text-gray-800 dark:text-gray-100 font-medium">{{ $digest->updated_at->diffForHumans() }}</span>
                            </div>

                            @if($digest->published_at)
                            <!-- Published date -->
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700/60">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M10.28 2.28L3.989 8.575 1.695 6.28A1 1 0 00.28 7.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 2.28z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Published</span>
                                </div>
                                <span class="text-sm text-green-600 dark:text-green-400 font-medium">{{ $digest->published_at->format('M d, Y') }}</span>
                            </div>
                            @endif

                            <!-- Slug -->
                            <div class="pt-3">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 mb-2">
                                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M6.5 9.5l3-3M7 6.5h.01M9 8.5h.01M14 8a6 6 0 11-12 0 6 6 0 0112 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Slug</span>
                                </div>
                                <code class="text-xs text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-900/50 px-2 py-1 rounded font-mono">{{ $digest->slug }}</code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Section (Livewire Component) -->
        <div class="mt-8">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Manage Items</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Add, edit, and organize the items in your digest</p>
            </div>
            <livewire:digests.item-manager :digest="$digest" />
        </div>

    </div>
</x-app-layout>
