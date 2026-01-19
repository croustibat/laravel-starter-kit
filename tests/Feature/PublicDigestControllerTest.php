<?php

namespace Tests\Feature;

use App\Models\Digest;
use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicDigestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_published_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create([
            'title' => 'My Published Digest',
        ]);

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertViewIs('pages.public.digest');
        $response->assertViewHas('digest');
        $response->assertSee('My Published Digest');
    }

    public function test_guests_cannot_view_draft_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create([
            'status' => 'draft',
        ]);

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(404);
    }

    public function test_guests_get_404_for_nonexistent_digest(): void
    {
        $response = $this->get('/d/nonexistent-slug');

        $response->assertStatus(404);
    }

    public function test_published_digest_displays_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $item1 = Item::factory()->for($user)->create([
            'title' => 'First Article',
            'description' => 'First article description',
        ]);
        $item2 = Item::factory()->for($user)->create([
            'title' => 'Second Article',
            'description' => 'Second article description',
        ]);

        $digest->items()->attach($item1, ['order' => 1]);
        $digest->items()->attach($item2, ['order' => 2]);

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertSee('First Article');
        $response->assertSee('First article description');
        $response->assertSee('Second Article');
        $response->assertSee('Second article description');
    }

    public function test_published_digest_displays_item_tags(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $tag1 = Tag::factory()->for($user)->create(['name' => 'Tech']);
        $tag2 = Tag::factory()->for($user)->create(['name' => 'Design']);

        $item = Item::factory()->for($user)->create([
            'title' => 'Article with Tags',
        ]);
        $item->tags()->attach([$tag1->id, $tag2->id]);

        $digest->items()->attach($item, ['order' => 1]);

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertSee('Tech');
        $response->assertSee('Design');
    }

    public function test_published_digest_displays_item_image_if_present(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $item = Item::factory()->for($user)->create([
            'title' => 'Article with Image',
            'image_url' => 'https://example.com/image.jpg',
        ]);

        $digest->items()->attach($item, ['order' => 1]);

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertSee('https://example.com/image.jpg');
    }

    public function test_published_digest_displays_item_url_if_present(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $item = Item::factory()->for($user)->create([
            'title' => 'Article with Link',
            'url' => 'https://example.com/article',
        ]);

        $digest->items()->attach($item, ['order' => 1]);

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertSee('example.com');
    }

    public function test_authenticated_users_can_view_published_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $response = $this->actingAs($user)->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertViewIs('pages.public.digest');
    }

    public function test_published_digest_shows_published_date(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertSee('Publié');
    }

    public function test_published_digest_shows_item_count(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $item1 = Item::factory()->for($user)->create();
        $item2 = Item::factory()->for($user)->create();
        $item3 = Item::factory()->for($user)->create();

        $digest->items()->attach($item1, ['order' => 1]);
        $digest->items()->attach($item2, ['order' => 2]);
        $digest->items()->attach($item3, ['order' => 3]);

        $response = $this->get(route('public.digest.show', $digest));

        $response->assertStatus(200);
        $response->assertSee('3 articles');
    }

    public function test_route_uses_slug_for_binding(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create([
            'slug' => 'my-custom-slug',
        ]);

        $response = $this->get('/d/my-custom-slug');

        $response->assertStatus(200);
        $response->assertViewHas('digest', function ($viewDigest) use ($digest) {
            return $viewDigest->id === $digest->id;
        });
    }
}
