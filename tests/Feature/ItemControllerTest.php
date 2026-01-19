<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_view_items_index(): void
    {
        $response = $this->get(route('items.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_items_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('items.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.items.index');
    }

    public function test_users_only_see_their_own_items_on_index(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userItem = Item::factory()->for($user)->create(['title' => 'My Item']);
        Item::factory()->for($otherUser)->create(['title' => 'Other Item']);

        $response = $this->actingAs($user)->get(route('items.index'));

        $response->assertStatus(200);
        $response->assertSee('My Item');
        $response->assertDontSee('Other Item');
    }

    public function test_items_index_can_search_by_title(): void
    {
        $user = User::factory()->create();
        Item::factory()->for($user)->create(['title' => 'Laravel Tutorial']);
        Item::factory()->for($user)->create(['title' => 'Vue Component']);

        $response = $this->actingAs($user)->get(route('items.index', ['search' => 'Laravel']));

        $response->assertStatus(200);
        $response->assertSee('Laravel Tutorial');
        $response->assertDontSee('Vue Component');
    }

    public function test_items_index_can_search_by_description(): void
    {
        $user = User::factory()->create();
        Item::factory()->for($user)->create(['title' => 'Item 1', 'description' => 'Laravel framework guide']);
        Item::factory()->for($user)->create(['title' => 'Item 2', 'description' => 'Vue basics']);

        $response = $this->actingAs($user)->get(route('items.index', ['search' => 'framework']));

        $response->assertStatus(200);
        $response->assertSee('Item 1');
        $response->assertDontSee('Item 2');
    }

    public function test_items_index_can_search_by_url(): void
    {
        $user = User::factory()->create();
        Item::factory()->for($user)->create(['title' => 'Item 1', 'url' => 'https://laravel.com']);
        Item::factory()->for($user)->create(['title' => 'Item 2', 'url' => 'https://vuejs.org']);

        $response = $this->actingAs($user)->get(route('items.index', ['search' => 'laravel.com']));

        $response->assertStatus(200);
        $response->assertSee('Item 1');
        $response->assertDontSee('Item 2');
    }

    public function test_guests_cannot_view_create_item_page(): void
    {
        $response = $this->get(route('items.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_create_item_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('items.create'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.items.create');
    }

    public function test_guests_cannot_store_item(): void
    {
        $response = $this->post(route('items.store'), [
            'title' => 'New Item',
            'url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_store_item(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => 'My New Item',
            'url' => 'https://example.com',
            'description' => 'Great resource',
        ]);

        $response->assertRedirect(route('items.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'title' => 'My New Item',
            'url' => 'https://example.com',
            'description' => 'Great resource',
        ]);
    }

    public function test_item_store_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => '',
            'url' => 'https://example.com',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_item_store_requires_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => 'My Item',
            'url' => '',
        ]);

        $response->assertSessionHasErrors('url');
    }

    public function test_item_store_requires_valid_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => 'My Item',
            'url' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors('url');
    }

    public function test_item_store_description_is_optional(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => 'My Item',
            'url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('items.index'));
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'title' => 'My Item',
            'url' => 'https://example.com',
            'description' => null,
        ]);
    }

    public function test_item_store_image_url_is_optional(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => 'My Item',
            'url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('items.index'));
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'title' => 'My Item',
            'image_url' => null,
        ]);
    }

    public function test_item_store_requires_valid_image_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('items.store'), [
            'title' => 'My Item',
            'url' => 'https://example.com',
            'image_url' => 'not-a-url',
        ]);

        $response->assertSessionHasErrors('image_url');
    }

    public function test_guests_cannot_view_edit_item_page(): void
    {
        $item = Item::factory()->create();

        $response = $this->get(route('items.edit', $item));

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_edit_their_own_item(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('items.edit', $item));

        $response->assertStatus(200);
        $response->assertViewIs('pages.items.edit');
        $response->assertViewHas('item');
    }

    public function test_users_cannot_edit_other_users_item(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $item = Item::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->get(route('items.edit', $item));

        $response->assertStatus(403);
    }

    public function test_edit_item_loads_tags(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();
        $tag = Tag::factory()->create(['name' => 'Laravel']);
        $item->tags()->attach($tag);

        $response = $this->actingAs($user)->get(route('items.edit', $item));

        $response->assertStatus(200);
        $response->assertSee('Laravel');
    }

    public function test_guests_cannot_update_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->put(route('items.update', $item), [
            'title' => 'Updated Title',
            'url' => 'https://example.com',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_update_their_own_item(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create(['title' => 'Original Title']);

        $response = $this->actingAs($user)->put(route('items.update', $item), [
            'title' => 'Updated Title',
            'url' => 'https://example.com',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect(route('items.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'title' => 'Updated Title',
            'url' => 'https://example.com',
            'description' => 'Updated description',
        ]);
    }

    public function test_users_cannot_update_other_users_item(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $item = Item::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->put(route('items.update', $item), [
            'title' => 'Hacked Title',
            'url' => 'https://hacker.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_update_item_requires_title(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('items.update', $item), [
            'title' => '',
            'url' => 'https://example.com',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_update_item_requires_url(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('items.update', $item), [
            'title' => 'Valid Title',
            'url' => '',
        ]);

        $response->assertSessionHasErrors('url');
    }

    public function test_update_item_requires_valid_url(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('items.update', $item), [
            'title' => 'Valid Title',
            'url' => 'not-a-valid-url',
        ]);

        $response->assertSessionHasErrors('url');
    }

    public function test_guests_cannot_delete_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->delete(route('items.destroy', $item));

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_delete_their_own_item(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete(route('items.destroy', $item));

        $response->assertRedirect(route('items.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('items', [
            'id' => $item->id,
        ]);
    }

    public function test_users_cannot_delete_other_users_item(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $item = Item::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->delete(route('items.destroy', $item));

        $response->assertStatus(403);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
        ]);
    }

    public function test_deleting_item_removes_tag_associations(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->for($user)->create();
        $tag = Tag::factory()->create();
        $item->tags()->attach($tag);

        $this->assertDatabaseHas('item_tag', [
            'item_id' => $item->id,
            'tag_id' => $tag->id,
        ]);

        $this->actingAs($user)->delete(route('items.destroy', $item));

        $this->assertDatabaseMissing('item_tag', [
            'item_id' => $item->id,
        ]);

        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
        ]);
    }
}
