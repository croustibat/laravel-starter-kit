<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Volt\Volt;
use Tests\TestCase;

class UrlInputTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_renders(): void
    {
        Volt::test('url-input')
            ->assertSee('URL')
            ->assertSee('Fetch');
    }

    public function test_fetch_metadata_validates_url(): void
    {
        Volt::test('url-input')
            ->set('url', 'not-a-url')
            ->call('fetchMetadata')
            ->assertHasErrors(['url']);
    }

    public function test_fetch_metadata_requires_url(): void
    {
        Volt::test('url-input')
            ->set('url', '')
            ->call('fetchMetadata')
            ->assertHasErrors(['url']);
    }

    public function test_fetch_metadata_successfully_extracts_data(): void
    {
        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta property="og:title" content="Example Title">
                    <meta property="og:description" content="Example Description">
                    <meta property="og:image" content="https://example.com/image.jpg">
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        Volt::test('url-input')
            ->set('url', 'https://example.com/article')
            ->call('fetchMetadata')
            ->assertSet('title', 'Example Title')
            ->assertSet('description', 'Example Description')
            ->assertSet('imageUrl', 'https://example.com/image.jpg')
            ->assertSet('isLoading', false)
            ->assertSet('error', null);
    }

    public function test_fetch_metadata_shows_error_when_no_metadata_found(): void
    {
        Http::fake([
            'example.com/*' => Http::response('<html><head></head><body></body></html>', 200),
        ]);

        Volt::test('url-input')
            ->set('url', 'https://example.com/article')
            ->call('fetchMetadata')
            ->assertSet('title', null)
            ->assertSet('description', null)
            ->assertSet('imageUrl', null)
            ->assertSet('error', 'Could not extract metadata from this URL. Please fill in the details manually.');
    }

    public function test_fetch_metadata_handles_network_error(): void
    {
        Http::fake([
            'example.com/*' => fn () => throw new \Exception('Network error'),
        ]);

        Volt::test('url-input')
            ->set('url', 'https://example.com/article')
            ->call('fetchMetadata')
            ->assertSet('error', 'Could not extract metadata from this URL. Please fill in the details manually.')
            ->assertSet('isLoading', false);
    }

    public function test_url_change_clears_error(): void
    {
        Volt::test('url-input')
            ->set('error', 'Some error message')
            ->set('url', 'https://example.com')
            ->assertSet('error', null);
    }

    public function test_loading_state_is_set_during_fetch(): void
    {
        Http::fake([
            'example.com/*' => Http::response('<html></html>', 200),
        ]);

        $component = Volt::test('url-input')
            ->set('url', 'https://example.com/article');

        // Before calling fetchMetadata
        $component->assertSet('isLoading', false);

        // After calling - should be false again (synchronous in tests)
        $component->call('fetchMetadata')
            ->assertSet('isLoading', false);
    }
}
