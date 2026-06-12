<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $stats = [
            'items' => $user->items()->count(),
            'digests' => $user->digests()->count(),
            'drafts' => $user->digests()->where('status', 'draft')->count(),
            'published' => $user->digests()->where('status', 'published')->count(),
        ];

        $activeDigest = $user->digests()
            ->withCount('items')
            ->where('status', 'draft')
            ->latest('updated_at')
            ->first();

        $recentDigests = $user->digests()
            ->withCount('items')
            ->latest('updated_at')
            ->limit(3)
            ->get();

        $recentItems = $user->items()
            ->latest()
            ->limit(4)
            ->get();

        return view('pages/dashboard/dashboard', compact(
            'activeDigest',
            'recentDigests',
            'recentItems',
            'stats',
        ));
    }

    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
