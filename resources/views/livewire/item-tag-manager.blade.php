<div>
    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Tags
        </label>

        <!-- Selected tags -->
        @if($selectedTags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($selectedTags as $tag)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-500/20 text-violet-700 dark:text-violet-400 rounded-full text-sm font-medium">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.568 1.5H2.75a1.25 1.25 0 00-1.25 1.25v2.818c0 .331.132.65.366.884l5.318 5.318a1.5 1.5 0 002.121 0l2.89-2.89a1.5 1.5 0 000-2.12L6.453 1.865a1.25 1.25 0 00-.885-.365z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h.007v.007H4V4z"/>
                        </svg>
                        {{ $tag->name }}
                        <button
                            type="button"
                            wire:click="removeTag({{ $tag->id }})"
                            class="ml-1 hover:bg-violet-500/30 rounded-full p-0.5 transition"
                        >
                            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4l8 8M12 4l-8 8"/>
                            </svg>
                        </button>
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Search and add tags -->
        <div class="relative" x-data="{ showDropdown: false }">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                @focus="showDropdown = true"
                @click.away="showDropdown = false"
                placeholder="Search or create tags..."
                class="form-input w-full bg-white dark:bg-gray-900"
            />

            <!-- Dropdown -->
            <div
                x-show="showDropdown && ($wire.search.length > 0 || {{ $availableTags->count() }} > 0)"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-60 overflow-auto"
                x-cloak
            >
                <ul class="py-1">
                    @if($availableTags->isEmpty() && $search)
                        <li>
                            <button
                                type="button"
                                wire:click="createAndAddTag"
                                @click="showDropdown = false"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 flex items-center gap-2"
                            >
                                <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                                </svg>
                                <span>Create "<span class="font-semibold">{{ $search }}</span>"</span>
                            </button>
                        </li>
                    @endif

                    @foreach($availableTags as $tag)
                        <li>
                            <button
                                type="button"
                                wire:click="addTag({{ $tag->id }})"
                                @click="showDropdown = false"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 flex items-center gap-2"
                            >
                                <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.568 1.5H2.75a1.25 1.25 0 00-1.25 1.25v2.818c0 .331.132.65.366.884l5.318 5.318a1.5 1.5 0 002.121 0l2.89-2.89a1.5 1.5 0 000-2.12L6.453 1.865a1.25 1.25 0 00-.885-.365z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h.007v.007H4V4z"/>
                                </svg>
                                {{ $tag->name }}
                            </button>
                        </li>
                    @endforeach

                    @if($availableTags->isEmpty() && !$search)
                        <li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                            No tags available. Start typing to create one.
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
