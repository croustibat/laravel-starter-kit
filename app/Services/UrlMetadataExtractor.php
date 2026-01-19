<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UrlMetadataExtractor
{
    /**
     * Extract metadata from a URL.
     *
     * @param  string  $url  The URL to extract metadata from
     * @return array{title: string|null, description: string|null, image_url: string|null}
     */
    public function extract(string $url): array
    {
        try {
            $response = Http::timeout(5)
                ->get($url);

            if (! $response->successful()) {
                Log::warning('Failed to fetch URL metadata', [
                    'url' => $url,
                    'status' => $response->status(),
                ]);

                return $this->emptyMetadata();
            }

            $html = $response->body();

            return [
                'title' => $this->extractTitle($html),
                'description' => $this->extractDescription($html),
                'image_url' => $this->extractImage($html),
            ];
        } catch (\Exception $e) {
            Log::error('Error extracting URL metadata', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            return $this->emptyMetadata();
        }
    }

    /**
     * Extract title from HTML.
     */
    protected function extractTitle(string $html): ?string
    {
        // Try og:title first
        if (preg_match('/<meta\s+property=["\']og:title["\']\s+content=["\'](.*?)["\']/is', $html, $matches)) {
            return $this->cleanText($matches[1]);
        }

        // Fallback to <title> tag
        if (preg_match('/<title>(.*?)<\/title>/is', $html, $matches)) {
            return $this->cleanText($matches[1]);
        }

        return null;
    }

    /**
     * Extract description from HTML.
     */
    protected function extractDescription(string $html): ?string
    {
        // Try og:description first
        if (preg_match('/<meta\s+property=["\']og:description["\']\s+content=["\'](.*?)["\']/is', $html, $matches)) {
            return $this->cleanText($matches[1]);
        }

        // Fallback to meta description
        if (preg_match('/<meta\s+name=["\']description["\']\s+content=["\'](.*?)["\']/is', $html, $matches)) {
            return $this->cleanText($matches[1]);
        }

        return null;
    }

    /**
     * Extract image URL from HTML.
     */
    protected function extractImage(string $html): ?string
    {
        // Try og:image
        if (preg_match('/<meta\s+property=["\']og:image["\']\s+content=["\'](.*?)["\']/is', $html, $matches)) {
            return $this->cleanText($matches[1]);
        }

        return null;
    }

    /**
     * Clean extracted text.
     */
    protected function cleanText(string $text): string
    {
        return html_entity_decode(trim($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Return empty metadata array.
     *
     * @return array{title: null, description: null, image_url: null}
     */
    protected function emptyMetadata(): array
    {
        return [
            'title' => null,
            'description' => null,
            'image_url' => null,
        ];
    }
}
