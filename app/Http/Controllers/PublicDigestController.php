<?php

namespace App\Http\Controllers;

use App\Models\Digest;
use Illuminate\View\View;

class PublicDigestController extends Controller
{
    public function show(Digest $digest): View
    {
        // Only show published digests
        abort_if($digest->status !== 'published', 404);

        // Load items with their tags
        $digest->load(['items.tags']);

        return view('pages.public.digest', compact('digest'));
    }
}
