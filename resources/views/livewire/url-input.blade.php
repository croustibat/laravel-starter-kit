<?php

use App\Services\UrlMetadataExtractor;
use Livewire\Volt\Component;

new class extends Component {
    public string $url = '';
    public ?string $title = null;
    public ?string $description = null;
    public ?string $imageUrl = null;
    public bool $isLoading = false;
    public ?string $error = null;

    public function fetchMetadata(): void
    {
        $this->error = null;

        // Validate URL
        $this->validate([
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $this->isLoading = true;

        try {
            $extractor = app(UrlMetadataExtractor::class);
            $metadata = $extractor->extract($this->url);

            $this->title = $metadata['title'];
            $this->description = $metadata['description'];
            $this->imageUrl = $metadata['image_url'];

            if (!$this->title && !$this->description && !$this->imageUrl) {
                $this->error = 'Could not extract metadata from this URL. Please fill in the details manually.';
            }
        } catch (\Exception $e) {
            $this->error = 'Failed to fetch metadata. Please try again or fill in the details manually.';
        } finally {
            $this->isLoading = false;
        }
    }

    public function updatedUrl(): void
    {
        $this->error = null;
    }
}; ?>

<div>
    <div class="space-y-4">
        <div>
            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                URL
            </label>
            <div class="flex gap-2">
                <input
                    wire:model.live.debounce.500ms="url"
                    type="url"
                    id="url"
                    class="form-input flex-grow"
                    placeholder="https://example.com/article"
                />
                <button
                    wire:click="fetchMetadata"
                    wire:loading.attr="disabled"
                    type="button"
                    class="btn bg-violet-500 text-white hover:bg-violet-600 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove wire:target="fetchMetadata">
                        <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M8 3v10M3 8h10"/>
                        </svg>
                        <span class="ml-2">Fetch</span>
                    </span>
                    <span wire:loading wire:target="fetchMetadata">
                        <svg class="animate-spin w-4 h-4" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="ml-2">Fetching...</span>
                    </span>
                </button>
            </div>
            @error('url')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            @if($error)
                <p class="mt-1 text-sm text-amber-600 dark:text-amber-400">{{ $error }}</p>
            @endif
        </div>

        @if($title || $description || $imageUrl)
            <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm font-medium text-green-800 dark:text-green-300 mb-2">Metadata extracted successfully</p>
                <div class="space-y-2 text-sm text-green-700 dark:text-green-400">
                    @if($title)
                        <div>
                            <span class="font-medium">Title:</span> {{ $title }}
                        </div>
                    @endif
                    @if($description)
                        <div>
                            <span class="font-medium">Description:</span> {{ Str::limit($description, 100) }}
                        </div>
                    @endif
                    @if($imageUrl)
                        <div>
                            <span class="font-medium">Image:</span>
                            <a href="{{ $imageUrl }}" target="_blank" class="text-violet-600 dark:text-violet-400 hover:underline">
                                View image
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Title
            </label>
            <input
                wire:model="title"
                type="text"
                id="title"
                class="form-input w-full"
                placeholder="Article title"
            />
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Description
            </label>
            <textarea
                wire:model="description"
                id="description"
                rows="3"
                class="form-input w-full"
                placeholder="Brief description"
            ></textarea>
        </div>

        <div>
            <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Image URL
            </label>
            <input
                wire:model="imageUrl"
                type="url"
                id="image_url"
                class="form-input w-full"
                placeholder="https://example.com/image.jpg"
            />
        </div>
    </div>
</div>
