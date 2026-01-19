<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UrlMetadataExtractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UrlMetadataController extends Controller
{
    public function __construct(protected UrlMetadataExtractor $extractor) {}

    /**
     * Extract metadata from a URL.
     */
    public function extract(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $metadata = $this->extractor->extract($validated['url']);

        return response()->json([
            'success' => true,
            'data' => $metadata,
        ]);
    }
}
