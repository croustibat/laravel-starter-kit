<?php

namespace Tests\Unit;

use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $tag->user);
        $this->assertEquals($user->id, $tag->user->id);
    }

    public function test_tag_belongs_to_many_items(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create();
        $items = Item::factory()->for($user)->count(3)->create();

        $tag->items()->attach($items);

        $this->assertCount(3, $tag->items);
        $this->assertInstanceOf(Item::class, $tag->items->first());
    }

    public function test_tag_fillable_attributes(): void
    {
        $user = User::factory()->create();

        $tag = new Tag([
            'name' => 'Technology',
            'slug' => 'technology',
        ]);
        $tag->user()->associate($user);
        $tag->save();

        $this->assertEquals('Technology', $tag->name);
        $this->assertEquals('technology', $tag->slug);
    }

    public function test_tag_slug_is_unique_per_user(): void
    {
        $user = User::factory()->create();

        Tag::factory()->for($user)->create(['slug' => 'unique-tag']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Tag::factory()->for($user)->create(['slug' => 'unique-tag']);
    }

    public function test_different_users_can_have_same_tag_slug(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $tag1 = Tag::factory()->for($user1)->create(['slug' => 'shared-slug', 'name' => 'Tag 1']);
        $tag2 = Tag::factory()->for($user2)->create(['slug' => 'shared-slug', 'name' => 'Tag 2']);

        $this->assertEquals($tag1->slug, $tag2->slug);
        $this->assertNotEquals($tag1->user_id, $tag2->user_id);
    }

    public function test_deleting_user_cascades_to_tags(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create();

        $this->assertDatabaseHas('tags', ['id' => $tag->id]);

        $user->delete();

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    public function test_deleting_tag_removes_pivot_entries_but_keeps_items(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create();

        $tag->items()->attach($item);

        $this->assertDatabaseHas('item_tag', [
            'tag_id' => $tag->id,
            'item_id' => $item->id,
        ]);

        $tag->delete();

        $this->assertDatabaseMissing('item_tag', ['tag_id' => $tag->id]);
        $this->assertDatabaseHas('items', ['id' => $item->id]);
    }

    public function test_tag_can_be_shared_across_multiple_items(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create(['name' => 'Laravel']);

        $item1 = Item::factory()->for($user)->create(['title' => 'Article 1']);
        $item2 = Item::factory()->for($user)->create(['title' => 'Article 2']);
        $item3 = Item::factory()->for($user)->create(['title' => 'Article 3']);

        $tag->items()->attach([$item1->id, $item2->id, $item3->id]);

        $this->assertCount(3, $tag->items);
        $this->assertTrue($tag->items->contains($item1));
        $this->assertTrue($tag->items->contains($item2));
        $this->assertTrue($tag->items->contains($item3));
    }

    public function test_item_can_have_multiple_tags(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $tag1 = Tag::factory()->for($user)->create(['name' => 'PHP']);
        $tag2 = Tag::factory()->for($user)->create(['name' => 'Laravel']);
        $tag3 = Tag::factory()->for($user)->create(['name' => 'Web']);

        $item->tags()->attach([$tag1->id, $tag2->id, $tag3->id]);

        $this->assertCount(3, $item->tags);
    }
}
