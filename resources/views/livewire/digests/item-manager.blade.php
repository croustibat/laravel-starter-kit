<?php

use App\Models\Digest;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public Digest $digest;
    public string $search = '';
    public bool $showAddModal = false;

    public function mount(Digest $digest): void
    {
        $this->digest = $digest;
    }

    public function getDigestItemsProperty()
    {
        return $this->digest->items()->orderBy('order')->get();
    }

    public function getAvailableItemsProperty()
    {
        $existingItemIds = $this->digest->items()->pluck('items.id')->toArray();

        return Auth::user()->items()
            ->whereNotIn('id', $existingItemIds)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('url', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function sortItems($itemId, $position): void
    {
        $item = $this->digest->items()->where('items.id', $itemId)->first();

        if (! $item) {
            return;
        }

        $items = $this->digest->items()->orderBy('order')->get();
        $currentPosition = $items->search(fn ($i) => $i->id === (int) $itemId);

        if ($currentPosition === false) {
            return;
        }

        $items = $items->values();
        $movedItem = $items->pull($currentPosition);
        $items->splice($position, 0, [$movedItem]);

        foreach ($items as $index => $item) {
            $this->digest->items()->updateExistingPivot($item->id, ['order' => $index]);
        }

        $this->digest->refresh();
    }

    public function addItem(int $itemId): void
    {
        $item = Auth::user()->items()->find($itemId);

        if (! $item) {
            return;
        }

        if ($this->digest->items()->where('items.id', $itemId)->exists()) {
            return;
        }

        $maxOrder = $this->digest->items()->max('order') ?? -1;
        $this->digest->items()->attach($itemId, ['order' => $maxOrder + 1]);

        $this->digest->refresh();
        $this->search = '';
    }

    public function removeItem(int $itemId): void
    {
        $this->digest->items()->detach($itemId);

        $items = $this->digest->items()->orderBy('order')->get();
        foreach ($items as $index => $item) {
            $this->digest->items()->updateExistingPivot($item->id, ['order' => $index]);
        }

        $this->digest->refresh();
    }

    public function openAddModal(): void
    {
        $this->showAddModal = true;
        $this->search = '';
    }

    public function closeAddModal(): void
    {
        $this->showAddModal = false;
        $this->search = '';
    }
}; ?>

<div>
    <div class="bg-white dark:bg-gray-800 shadow-xs rounded-xl">
        <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Items in this Digest</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $this->digestItems->count() }} items</span>
                    <button
                        wire:click="openAddModal"
                        class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white"
                    >
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                            <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                        </svg>
                        <span class="ml-2">Add Item</span>
                    </button>
                </div>
            </div>
        </header>

        <div class="p-6">
            @if($this->digestItems->isEmpty())
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No items in this digest yet.</p>
                    <button
                        wire:click="openAddModal"
                        class="text-sm text-violet-500 hover:text-violet-600 font-medium"
                    >
                        Add your first item
                    </button>
                </div>
            @else
                <ul wire:sort="sortItems" class="space-y-3">
                    @foreach($this->digestItems as $item)
                        <li
                            wire:sort:item="{{ $item->id }}"
                            wire:key="item-{{ $item->id }}"
                            class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg cursor-move hover:bg-gray-100 dark:hover:bg-gray-900/70 transition-colors"
                        >
                            <div wire:sort:handle class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-full text-sm font-medium text-gray-600 dark:text-gray-300 cursor-grab active:cursor-grabbing">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-grow min-w-0">
                                <h4 class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ $item->title }}</h4>
                                @if($item->url)
                                    <a href="{{ $item->url }}" target="_blank" class="text-xs text-violet-500 hover:text-violet-600 truncate block" wire:sort:ignore>
                                        {{ parse_url($item->url, PHP_URL_HOST) }}
                                        <svg class="w-3 h-3 inline-block ml-1" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M3.5 3.5h5v5M8.5 3.5l-5 5"/>
                                        </svg>
                                    </a>
                                @endif
                                @if($item->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">{{ $item->description }}</p>
                                @endif
                            </div>
                            @if($item->tags->isNotEmpty())
                                <div class="flex-shrink-0 flex gap-1" wire:sort:ignore>
                                    @foreach($item->tags->take(2) as $tag)
                                        <span class="text-xs inline-flex font-medium bg-violet-500/20 text-violet-700 dark:text-violet-300 rounded-full px-2 py-0.5">{{ $tag->name }}</span>
                                    @endforeach
                                    @if($item->tags->count() > 2)
                                        <span class="text-xs text-gray-400">+{{ $item->tags->count() - 2 }}</span>
                                    @endif
                                </div>
                            @endif
                            <button
                                wire:click="removeItem({{ $item->id }})"
                                wire:sort:ignore
                                class="flex-shrink-0 p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors"
                                title="Remove from digest"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4l8 8M12 4l-8 8"/>
                                </svg>
                            </button>
                        </li>
                    @endforeach
                </ul>
                <p class="mt-4 text-xs text-gray-400 dark:text-gray-500 text-center">
                    <svg class="w-4 h-4 inline-block mr-1" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 5h10M3 8h10M3 11h10"/>
                    </svg>
                    Drag items to reorder
                </p>
            @endif
        </div>
    </div>

    @if($showAddModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div
                class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 transition-opacity"
                aria-hidden="true"
                wire:click="closeAddModal"
            ></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100" id="modal-title">
                            Add Items
                        </h3>
                        <button
                            wire:click="closeAddModal"
                            class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                        >
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-4">
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            class="form-input w-full"
                            placeholder="Search your items..."
                            autofocus
                        />
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        @if($this->availableItems->isEmpty())
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    @if($search)
                                        No items found matching "{{ $search }}"
                                    @else
                                        No more items available to add.
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                    Create new items in the admin panel.
                                </p>
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach($this->availableItems as $item)
                                    <div
                                        wire:key="available-{{ $item->id }}"
                                        class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900/70 transition-colors"
                                    >
                                        <div class="flex-grow min-w-0">
                                            <h4 class="text-sm font-medium text-gray-800 dark:text-gray-100 truncate">{{ $item->title }}</h4>
                                            @if($item->url)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ parse_url($item->url, PHP_URL_HOST) }}</p>
                                            @endif
                                        </div>
                                        <button
                                            wire:click="addItem({{ $item->id }})"
                                            class="flex-shrink-0 btn-sm bg-violet-500 text-white hover:bg-violet-600 rounded-lg px-3 py-1.5 text-xs font-medium"
                                        >
                                            Add
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700/60">
                    <button
                        wire:click="closeAddModal"
                        class="btn w-full border-gray-200 dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300"
                    >
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
