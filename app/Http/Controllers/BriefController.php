<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BriefController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $sourceCount = $user->items()->count();
        $draftCount = $user->digests()->where('status', 'draft')->count();

        $suggestedSources = $user->items()
            ->latest()
            ->limit(4)
            ->get();

        return view('pages.briefs.index', compact(
            'draftCount',
            'sourceCount',
            'suggestedSources',
        ));
    }
}
