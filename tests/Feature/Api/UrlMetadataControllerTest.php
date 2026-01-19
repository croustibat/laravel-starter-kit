<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlMetadataControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_extract_metadata_requires_authentication(): void
    {
        $response = $this->postJson('/api/url-metadata', [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(401);
    }

    public function test_extract_metadata_validates_url(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/url-metadata', [
            'url' => 'not-a-valid-url',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['url']);
    }

    public function test_extract_metadata_requires_url(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/api/url-metadata', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['url']);
    }

    public function test_extract_metadata_successfully(): void
    {
        $this->actingAs($this->user);

        Http::fake([
            'example.com/*' => Http::response('
                <!DOCTYPE html>
                <html>
                <head>
                    <meta property="og:title" content="Test Article">
                    <meta property="og:description" content="Test Description">
                    <meta property="og:image" content="https://example.com/image.jpg">
                </head>
                <body></body>
                </html>
            ', 200),
        ]);

        $response = $this->postJson('/api/url-metadata', [
            'url' => 'https://example.com/article',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'title' => 'Test Article',
                'description' => 'Test Description',
                'image_url' => 'https://example.com/image.jpg',
            ],
        ]);
    }

    public function test_extract_metadata_handles_failed_request(): void
    {
        $this->actingAs($this->user);

        Http::fake([
            'example.com/*' => Http::response('', 404),
        ]);

        $response = $this->postJson('/api/url-metadata', [
            'url' => 'https://example.com/notfound',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'title' => null,
                'description' => null,
                'image_url' => null,
            ],
        ]);
    }

    public function test_extract_metadata_rejects_too_long_url(): void
    {
        $this->actingAs($this->user);

        $longUrl = 'https://example.com/'.str_repeat('a', 2050);

        $response = $this->postJson('/api/url-metadata', [
            'url' => $longUrl,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['url']);
    }
}
