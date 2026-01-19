<?php

namespace Tests\Unit;

use App\Services\UrlMetadataExtractor;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlMetadataExtractorTest extends TestCase
{
    protected UrlMetadataExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extractor = new UrlMetadataExtractor;
    }

    public function test_extract_og_tags(): void
    {
        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta property="og:title" content="Test Article Title">
                    <meta property="og:description" content="This is a test description">
                    <meta property="og:image" content="https://example.com/image.jpg">
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        $metadata = $this->extractor->extract('https://example.com/article');

        $this->assertEquals('Test Article Title', $metadata['title']);
        $this->assertEquals('This is a test description', $metadata['description']);
        $this->assertEquals('https://example.com/image.jpg', $metadata['image_url']);
    }

    public function test_fallback_to_title_tag(): void
    {
        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Fallback Title</title>
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        $metadata = $this->extractor->extract('https://example.com/article');

        $this->assertEquals('Fallback Title', $metadata['title']);
        $this->assertNull($metadata['description']);
        $this->assertNull($metadata['image_url']);
    }

    public function test_fallback_to_meta_description(): void
    {
        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Article Title</title>
                    <meta name="description" content="Standard meta description">
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        $metadata = $this->extractor->extract('https://example.com/article');

        $this->assertEquals('Article Title', $metadata['title']);
        $this->assertEquals('Standard meta description', $metadata['description']);
        $this->assertNull($metadata['image_url']);
    }

    public function test_html_entities_are_decoded(): void
    {
        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta property="og:title" content="Test &amp; Article &quot;Title&quot;">
                    <meta property="og:description" content="Description with &#39;quotes&#39;">
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        $metadata = $this->extractor->extract('https://example.com/article');

        $this->assertEquals('Test & Article "Title"', $metadata['title']);
        $this->assertEquals("Description with 'quotes'", $metadata['description']);
    }

    public function test_handles_404_error(): void
    {
        Http::fake([
            'example.com/*' => Http::response('', 404),
        ]);

        $metadata = $this->extractor->extract('https://example.com/nonexistent');

        $this->assertNull($metadata['title']);
        $this->assertNull($metadata['description']);
        $this->assertNull($metadata['image_url']);
    }

    public function test_handles_network_timeout(): void
    {
        Http::fake([
            'example.com/*' => fn () => throw new \Illuminate\Http\Client\ConnectionException('Connection timeout'),
        ]);

        $metadata = $this->extractor->extract('https://example.com/slow');

        $this->assertNull($metadata['title']);
        $this->assertNull($metadata['description']);
        $this->assertNull($metadata['image_url']);
    }

    public function test_handles_server_error(): void
    {
        Http::fake([
            'example.com/*' => Http::response('', 500),
        ]);

        $metadata = $this->extractor->extract('https://example.com/error');

        $this->assertNull($metadata['title']);
        $this->assertNull($metadata['description']);
        $this->assertNull($metadata['image_url']);
    }

    public function test_handles_empty_response(): void
    {
        Http::fake([
            'example.com/*' => Http::response('', 200),
        ]);

        $metadata = $this->extractor->extract('https://example.com/empty');

        $this->assertNull($metadata['title']);
        $this->assertNull($metadata['description']);
        $this->assertNull($metadata['image_url']);
    }

    public function test_og_tags_take_priority_over_standard_tags(): void
    {
        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Standard Title</title>
                    <meta name="description" content="Standard Description">
                    <meta property="og:title" content="OG Title">
                    <meta property="og:description" content="OG Description">
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        $metadata = $this->extractor->extract('https://example.com/article');

        $this->assertEquals('OG Title', $metadata['title']);
        $this->assertEquals('OG Description', $metadata['description']);
    }

    public function test_trims_whitespace_from_metadata(): void
    {
        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta property="og:title" content="  Title with spaces  ">
                    <meta property="og:description" content="
                        Description with newlines
                    ">
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        $metadata = $this->extractor->extract('https://example.com/article');

        $this->assertEquals('Title with spaces', $metadata['title']);
        $this->assertStringContainsString('Description with newlines', $metadata['description']);
    }
}
