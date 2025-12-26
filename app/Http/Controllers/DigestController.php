<?php

namespace App\Http\Controllers;

use App\Models\Digest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DigestController extends Controller
{
    public function index(): View
    {
        $digests = auth()->user()->digests()->latest()->get();

        return view('pages.digests.index', compact('digests'));
    }

    public function create(): View
    {
        return view('pages.digests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        auth()->user()->digests()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'status' => 'draft',
        ]);

        return redirect()->route('digests.index')->with('success', 'Digest created successfully.');
    }

    public function show(Digest $digest): View
    {
        $this->authorize('view', $digest);

        return view('pages.digests.show', compact('digest'));
    }

    public function edit(Digest $digest): View
    {
        $this->authorize('update', $digest);

        return view('pages.digests.edit', compact('digest'));
    }

    public function update(Request $request, Digest $digest)
    {
        $this->authorize('update', $digest);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        $digest->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        return redirect()->route('digests.index')->with('success', 'Digest updated successfully.');
    }

    public function destroy(Digest $digest)
    {
        $this->authorize('delete', $digest);

        $digest->delete();

        return redirect()->route('digests.index')->with('success', 'Digest deleted successfully.');
    }
}
