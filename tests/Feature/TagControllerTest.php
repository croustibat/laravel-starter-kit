<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_view_tags_index(): void
    {
        $response = $this->get(route('tags.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_tags_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tags.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.tags.index');
    }

    public function test_users_only_see_their_own_tags_on_index(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userTag = Tag::factory()->for($user)->create(['name' => 'My Tag']);
        Tag::factory()->for($otherUser)->create(['name' => 'Other Tag']);

        $response = $this->actingAs($user)->get(route('tags.index'));

        $response->assertStatus(200);
        $response->assertSee('My Tag');
        $response->assertDontSee('Other Tag');
    }

    public function test_tags_index_displays_items_count(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create(['name' => 'Tech']);
        $item = Item::factory()->for($user)->create();
        $tag->items()->attach($item);

        $response = $this->actingAs($user)->get(route('tags.index'));

        $response->assertStatus(200);
        $response->assertSee('1 item');
    }

    public function test_guests_cannot_store_tag(): void
    {
        $response = $this->post(route('tags.store'), [
            'name' => 'New Tag',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_store_tag(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tags.store'), [
            'name' => 'My New Tag',
        ]);

        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tags', [
            'user_id' => $user->id,
            'name' => 'My New Tag',
            'slug' => 'my-new-tag',
        ]);
    }

    public function test_tag_store_requires_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tags.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_tag_store_name_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tags.store'), [
            'name' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_tag_store_generates_unique_slug_per_user(): void
    {
        $user = User::factory()->create();
        Tag::factory()->for($user)->create(['name' => 'Tech', 'slug' => 'tech']);

        $response = $this->actingAs($user)->post(route('tags.store'), [
            'name' => 'Tech',
        ]);

        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tags', [
            'user_id' => $user->id,
            'name' => 'Tech',
            'slug' => 'tech-1',
        ]);
    }

    public function test_different_users_can_have_same_tag_slug(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Tag::factory()->for($user1)->create(['name' => 'Tech', 'slug' => 'tech']);

        $this->actingAs($user2)->post(route('tags.store'), [
            'name' => 'Tech',
        ]);

        $this->assertDatabaseHas('tags', [
            'user_id' => $user2->id,
            'name' => 'Tech',
            'slug' => 'tech',
        ]);
    }

    public function test_guests_cannot_update_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->put(route('tags.update', $tag), [
            'name' => 'Updated Tag',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_update_their_own_tag(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create(['name' => 'Original Tag']);

        $response = $this->actingAs($user)->put(route('tags.update', $tag), [
            'name' => 'Updated Tag',
        ]);

        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'Updated Tag',
            'slug' => 'updated-tag',
        ]);
    }

    public function test_users_cannot_update_other_users_tag(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $tag = Tag::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->put(route('tags.update', $tag), [
            'name' => 'Hacked Tag',
        ]);

        $response->assertStatus(403);
    }

    public function test_update_tag_requires_name(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('tags.update', $tag), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_update_tag_generates_unique_slug_per_user_excluding_current(): void
    {
        $user = User::factory()->create();
        $tag1 = Tag::factory()->for($user)->create(['name' => 'Tech', 'slug' => 'tech']);
        $tag2 = Tag::factory()->for($user)->create(['name' => 'Other', 'slug' => 'other']);

        $response = $this->actingAs($user)->put(route('tags.update', $tag2), [
            'name' => 'Tech',
        ]);

        $response->assertRedirect(route('tags.index'));

        $this->assertDatabaseHas('tags', [
            'id' => $tag2->id,
            'name' => 'Tech',
            'slug' => 'tech-1',
        ]);
    }

    public function test_guests_cannot_delete_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->delete(route('tags.destroy', $tag));

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_delete_their_own_tag(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete(route('tags.destroy', $tag));

        $response->assertRedirect(route('tags.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }

    public function test_users_cannot_delete_other_users_tag(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $tag = Tag::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->delete(route('tags.destroy', $tag));

        $response->assertStatus(403);

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
        ]);
    }

    public function test_deleting_tag_removes_it_from_items(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create();
        $item->tags()->attach($tag);

        $this->assertDatabaseHas('item_tag', [
            'item_id' => $item->id,
            'tag_id' => $tag->id,
        ]);

        $this->actingAs($user)->delete(route('tags.destroy', $tag));

        $this->assertDatabaseMissing('item_tag', [
            'tag_id' => $tag->id,
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
        ]);
    }

    public function test_tag_store_works_with_ajax_request(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('tags.store'), [
                'name' => 'Ajax Tag',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('tags', [
            'user_id' => $user->id,
            'name' => 'Ajax Tag',
        ]);
    }

    public function test_tag_update_works_with_ajax_request(): void
    {
        $user = User::factory()->create();
        $tag = Tag::factory()->for($user)->create(['name' => 'Original']);

        $response = $this->actingAs($user)
            ->putJson(route('tags.update', $tag), [
                'name' => 'Updated Ajax',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'Updated Ajax',
        ]);
    }

    public function test_tags_index_can_search_tags_by_name(): void
    {
        $user = User::factory()->create();
        Tag::factory()->for($user)->create(['name' => 'JavaScript']);
        Tag::factory()->for($user)->create(['name' => 'PHP']);

        $response = $this->actingAs($user)->get(route('tags.index', ['search' => 'Java']));

        $response->assertStatus(200);
        $response->assertSee('JavaScript');
        $response->assertDontSee('PHP');
    }
}
