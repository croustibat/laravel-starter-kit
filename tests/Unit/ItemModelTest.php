<?php

namespace Tests\Unit;

use App\Models\Digest;
use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $item->user);
        $this->assertEquals($user->id, $item->user->id);
    }

    public function test_item_belongs_to_many_digests(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();
        $digests = Digest::factory()->for($user)->count(3)->create();

        foreach ($digests as $index => $digest) {
            $item->digests()->attach($digest, ['order' => $index + 1]);
        }

        $this->assertCount(3, $item->digests);
        $this->assertInstanceOf(Digest::class, $item->digests->first());
    }

    public function test_item_digests_pivot_includes_order(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();
        $digest = Digest::factory()->for($user)->create();

        $item->digests()->attach($digest, ['order' => 7]);

        $this->assertEquals(7, $item->digests->first()->pivot->order);
    }

    public function test_item_belongs_to_many_tags(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();
        $tags = Tag::factory()->for($user)->count(3)->create();

        $item->tags()->attach($tags);

        $this->assertCount(3, $item->tags);
        $this->assertInstanceOf(Tag::class, $item->tags->first());
    }

    public function test_item_fillable_attributes(): void
    {
        $user = User::factory()->create();

        $item = new Item([
            'title' => 'Test Article',
            'url' => 'https://example.com/article',
            'description' => 'Test description',
            'image_url' => 'https://example.com/image.jpg',
        ]);
        $item->user()->associate($user);
        $item->save();

        $this->assertEquals('Test Article', $item->title);
        $this->assertEquals('https://example.com/article', $item->url);
        $this->assertEquals('Test description', $item->description);
        $this->assertEquals('https://example.com/image.jpg', $item->image_url);
    }

    public function test_item_can_exist_in_multiple_digests(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $digest1 = Digest::factory()->for($user)->create(['title' => 'Digest 1']);
        $digest2 = Digest::factory()->for($user)->create(['title' => 'Digest 2']);

        $item->digests()->attach($digest1, ['order' => 1]);
        $item->digests()->attach($digest2, ['order' => 2]);

        $this->assertCount(2, $item->digests);
        $this->assertTrue($item->digests->contains($digest1));
        $this->assertTrue($item->digests->contains($digest2));
    }

    public function test_deleting_user_cascades_to_items(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $this->assertDatabaseHas('items', ['id' => $item->id]);

        $user->delete();

        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    public function test_deleting_item_removes_pivot_entries_but_keeps_tags(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();
        $tag = Tag::factory()->for($user)->create();

        $item->tags()->attach($tag);

        $this->assertDatabaseHas('item_tag', [
            'item_id' => $item->id,
            'tag_id' => $tag->id,
        ]);

        $item->delete();

        $this->assertDatabaseMissing('item_tag', ['item_id' => $item->id]);
        $this->assertDatabaseHas('tags', ['id' => $tag->id]);
    }

    public function test_deleting_item_removes_digest_pivot_but_keeps_digests(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();
        $digest = Digest::factory()->for($user)->create();

        $item->digests()->attach($digest, ['order' => 1]);

        $this->assertDatabaseHas('digest_item', [
            'item_id' => $item->id,
            'digest_id' => $digest->id,
        ]);

        $item->delete();

        $this->assertDatabaseMissing('digest_item', ['item_id' => $item->id]);
        $this->assertDatabaseHas('digests', ['id' => $digest->id]);
    }
}
