<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Digest;
use App\Models\Item;
use App\Services\UrlMetadataExtractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $query = auth()->user()->items()->with('tags');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->paginate(12)->withQueryString();

        return view('pages.items.index', compact('items'));
    }

    public function create(): View
    {
        return view('pages.items.create');
    }

    public function store(StoreItemRequest $request, UrlMetadataExtractor $extractor): RedirectResponse
    {
        $validated = $request->validated();
        $metadata = [];

        if (blank($validated['title'] ?? null)) {
            $metadata = $extractor->extract($validated['url']);
        }

        $validated['title'] = filled($validated['title'] ?? null)
            ? $validated['title']
            : ($metadata['title'] ?? $this->fallbackTitleFromUrl($validated['url']));

        $validated['description'] = filled($validated['description'] ?? null)
            ? $validated['description']
            : ($metadata['description'] ?? null);

        $validated['image_url'] = filled($validated['image_url'] ?? null)
            ? $validated['image_url']
            : ($metadata['image_url'] ?? null);

        $item = $request->user()->items()->create($validated);

        return redirect()->route('items.edit', $item)->with('success', 'Source captured. Add your angle before using it in a digest.');
    }

    public function edit(Item $item): View
    {
        $this->authorize('update', $item);

        $item->load('tags');

        return view('pages.items.edit', compact('item'));
    }

    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $this->authorize('update', $item);

        $item->update($request->validated());

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function startDigest(Item $item): RedirectResponse
    {
        $this->authorize('update', $item);

        $digestTitle = "Édition autour de {$item->title}";

        $digest = $item->user->digests()->create([
            'title' => $digestTitle,
            'slug' => Digest::uniqueSlugForTitle($digestTitle),
            'status' => 'draft',
        ]);

        $digest->items()->attach($item, ['order' => 0]);

        return redirect()->route('digests.edit', $digest)->with('success', 'Digest started with your first source.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    private function fallbackTitleFromUrl(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);

        return $host ?: $url;
    }
}
