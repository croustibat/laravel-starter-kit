<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(Request $request): View
    {
        $query = auth()->user()->tags()->withCount('items');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $tags = $query->latest()->paginate(24)->withQueryString();

        return view('pages.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $slug = Str::slug($validated['name']);

        // Ensure unique slug per user
        $originalSlug = $slug;
        $counter = 1;
        while (auth()->user()->tags()->where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        $tag = auth()->user()->tags()->create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'tag' => $tag,
            ]);
        }

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $slug = Str::slug($validated['name']);

        // Ensure unique slug per user (excluding current tag)
        $originalSlug = $slug;
        $counter = 1;
        while (auth()->user()->tags()->where('slug', $slug)->where('id', '!=', $tag->id)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        $tag->update([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'tag' => $tag,
            ]);
        }

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}
