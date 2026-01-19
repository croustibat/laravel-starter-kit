<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Component;

class ItemTagManager extends Component
{
    public Item $item;

    public string $search = '';

    public array $selectedTagIds = [];

    public function mount(Item $item): void
    {
        $this->item = $item;
        $this->selectedTagIds = $item->tags->pluck('id')->toArray();
    }

    public function addTag(int $tagId): void
    {
        $tag = Tag::find($tagId);

        if (! $tag || $tag->user_id !== auth()->id()) {
            return;
        }

        if (! in_array($tagId, $this->selectedTagIds)) {
            $this->selectedTagIds[] = $tagId;
            $this->item->tags()->attach($tagId);
        }

        $this->search = '';
    }

    public function removeTag(int $tagId): void
    {
        $this->selectedTagIds = array_filter(
            $this->selectedTagIds,
            fn ($id) => $id !== $tagId
        );

        $this->item->tags()->detach($tagId);
    }

    public function createAndAddTag(): void
    {
        if (empty(trim($this->search))) {
            return;
        }

        $slug = Str::slug($this->search);

        // Ensure unique slug per user
        $originalSlug = $slug;
        $counter = 1;
        while (auth()->user()->tags()->where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        $tag = auth()->user()->tags()->create([
            'name' => $this->search,
            'slug' => $slug,
        ]);

        $this->addTag($tag->id);
    }

    public function render()
    {
        $availableTags = auth()->user()
            ->tags()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->whereNotIn('id', $this->selectedTagIds)
            ->orderBy('name')
            ->limit(10)
            ->get();

        $selectedTags = Tag::whereIn('id', $this->selectedTagIds)->get();

        return view('livewire.item-tag-manager', [
            'availableTags' => $availableTags,
            'selectedTags' => $selectedTags,
        ]);
    }
}
