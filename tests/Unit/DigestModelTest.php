<?php

namespace Tests\Unit;

use App\Models\Digest;
use App\Models\Item;
use App\Models\SocialPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DigestModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_digest_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $digest->user);
        $this->assertEquals($user->id, $digest->user->id);
    }

    public function test_digest_has_many_items_through_pivot(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $items = Item::factory()->for($user)->count(3)->create();

        foreach ($items as $index => $item) {
            $digest->items()->attach($item, ['order' => $index + 1]);
        }

        $this->assertCount(3, $digest->items);
        $this->assertInstanceOf(Item::class, $digest->items->first());
    }

    public function test_digest_items_are_ordered_by_pivot_order(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $item1 = Item::factory()->for($user)->create(['title' => 'First']);
        $item2 = Item::factory()->for($user)->create(['title' => 'Second']);
        $item3 = Item::factory()->for($user)->create(['title' => 'Third']);

        $digest->items()->attach($item3, ['order' => 3]);
        $digest->items()->attach($item1, ['order' => 1]);
        $digest->items()->attach($item2, ['order' => 2]);

        $digest->refresh();

        $this->assertEquals('First', $digest->items[0]->title);
        $this->assertEquals('Second', $digest->items[1]->title);
        $this->assertEquals('Third', $digest->items[2]->title);
    }

    public function test_digest_items_pivot_includes_order(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create();

        $digest->items()->attach($item, ['order' => 5]);

        $this->assertEquals(5, $digest->items->first()->pivot->order);
    }

    public function test_digest_has_many_social_posts(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        SocialPost::factory()->for($digest)->count(2)->create();

        $this->assertCount(2, $digest->socialPosts);
        $this->assertInstanceOf(SocialPost::class, $digest->socialPosts->first());
    }

    public function test_digest_fillable_attributes(): void
    {
        $user = User::factory()->create();

        $digest = new Digest([
            'title' => 'Test Title',
            'slug' => 'test-slug',
            'status' => 'published',
            'published_at' => now(),
        ]);
        $digest->user()->associate($user);
        $digest->save();

        $this->assertEquals('Test Title', $digest->title);
        $this->assertEquals('test-slug', $digest->slug);
        $this->assertEquals('published', $digest->status);
    }

    public function test_digest_casts_published_at_to_datetime(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $digest->published_at);
    }

    public function test_digest_factory_creates_draft_by_default(): void
    {
        $digest = Digest::factory()->create();

        $this->assertEquals('draft', $digest->status);
        $this->assertNull($digest->published_at);
    }

    public function test_digest_factory_published_state(): void
    {
        $digest = Digest::factory()->published()->create();

        $this->assertEquals('published', $digest->status);
        $this->assertNotNull($digest->published_at);
    }

    public function test_digest_slug_is_unique(): void
    {
        $user = User::factory()->create();

        Digest::factory()->for($user)->create(['slug' => 'unique-slug']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Digest::factory()->for($user)->create(['slug' => 'unique-slug']);
    }

    public function test_deleting_user_cascades_to_digests(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $this->assertDatabaseHas('digests', ['id' => $digest->id]);

        $user->delete();

        $this->assertDatabaseMissing('digests', ['id' => $digest->id]);
    }

    public function test_deleting_digest_cascades_to_social_posts(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $socialPost = SocialPost::factory()->for($digest)->create();

        $this->assertDatabaseHas('social_posts', ['id' => $socialPost->id]);

        $digest->delete();

        $this->assertDatabaseMissing('social_posts', ['id' => $socialPost->id]);
    }

    public function test_deleting_digest_removes_pivot_entries_but_keeps_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create();

        $digest->items()->attach($item, ['order' => 1]);

        $this->assertDatabaseHas('digest_item', [
            'digest_id' => $digest->id,
            'item_id' => $item->id,
        ]);

        $digest->delete();

        $this->assertDatabaseMissing('digest_item', ['digest_id' => $digest->id]);
        $this->assertDatabaseHas('items', ['id' => $item->id]);
    }
}
