<?php

namespace Tests\Feature;

use App\Models\Digest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DigestControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_view_digests_index(): void
    {
        $response = $this->get(route('digests.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_digests_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('digests.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.digests.index');
    }

    public function test_users_only_see_their_own_digests_on_index(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userDigest = Digest::factory()->for($user)->create(['title' => 'My Digest']);
        Digest::factory()->for($otherUser)->create(['title' => 'Other Digest']);

        $response = $this->actingAs($user)->get(route('digests.index'));

        $response->assertStatus(200);
        $response->assertSee('My Digest');
        $response->assertDontSee('Other Digest');
    }

    public function test_guests_cannot_view_create_digest_page(): void
    {
        $response = $this->get(route('digests.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_create_digest_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('digests.create'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.digests.create');
    }

    public function test_guests_cannot_store_digest(): void
    {
        $response = $this->post(route('digests.store'), [
            'title' => 'New Digest',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_store_digest(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('digests.store'), [
            'title' => 'My New Digest',
        ]);

        $response->assertRedirect(route('digests.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('digests', [
            'user_id' => $user->id,
            'title' => 'My New Digest',
            'slug' => 'my-new-digest',
            'status' => 'draft',
        ]);
    }

    public function test_digest_store_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('digests.store'), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_digest_store_title_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('digests.store'), [
            'title' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_guests_cannot_view_digest(): void
    {
        $digest = Digest::factory()->create();

        $response = $this->get(route('digests.show', $digest));

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_view_their_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('digests.show', $digest));

        $response->assertStatus(200);
        $response->assertViewIs('pages.digests.show');
        $response->assertViewHas('digest');
    }

    public function test_users_cannot_view_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->get(route('digests.show', $digest));

        $response->assertStatus(403);
    }

    public function test_show_digest_loads_items_and_social_posts(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create();
        $digest->items()->attach($item, ['order' => 1]);

        $response = $this->actingAs($user)->get(route('digests.show', $digest));

        $response->assertStatus(200);
        $response->assertSee($item->title);
    }

    public function test_guests_cannot_view_edit_digest_page(): void
    {
        $digest = Digest::factory()->create();

        $response = $this->get(route('digests.edit', $digest));

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_edit_their_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('digests.edit', $digest));

        $response->assertStatus(200);
        $response->assertViewIs('pages.digests.edit');
        $response->assertViewHas('digest');
    }

    public function test_users_cannot_edit_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->get(route('digests.edit', $digest));

        $response->assertStatus(403);
    }

    public function test_guests_cannot_update_digest(): void
    {
        $digest = Digest::factory()->create();

        $response = $this->put(route('digests.update', $digest), [
            'title' => 'Updated Title',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_update_their_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create(['title' => 'Original Title']);

        $response = $this->actingAs($user)->put(route('digests.update', $digest), [
            'title' => 'Updated Title',
            'status' => 'draft',
        ]);

        $response->assertRedirect(route('digests.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('digests', [
            'id' => $digest->id,
            'title' => 'Updated Title',
            'slug' => 'updated-title',
        ]);
    }

    public function test_users_cannot_update_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->put(route('digests.update', $digest), [
            'title' => 'Hacked Title',
            'status' => 'published',
        ]);

        $response->assertStatus(403);
    }

    public function test_update_digest_requires_title(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('digests.update', $digest), [
            'title' => '',
            'status' => 'draft',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_update_digest_requires_valid_status(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $response = $this->actingAs($user)->put(route('digests.update', $digest), [
            'title' => 'Valid Title',
            'status' => 'invalid_status',
        ]);

        $response->assertSessionHasErrors('status');
    }

    public function test_publishing_digest_sets_published_at(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create([
            'status' => 'draft',
            'published_at' => null,
        ]);

        $this->actingAs($user)->put(route('digests.update', $digest), [
            'title' => $digest->title,
            'status' => 'published',
        ]);

        $digest->refresh();
        $this->assertEquals('published', $digest->status);
        $this->assertNotNull($digest->published_at);
    }

    public function test_unpublishing_digest_clears_published_at(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $this->actingAs($user)->put(route('digests.update', $digest), [
            'title' => $digest->title,
            'status' => 'draft',
        ]);

        $digest->refresh();
        $this->assertEquals('draft', $digest->status);
        $this->assertNull($digest->published_at);
    }

    public function test_guests_cannot_delete_digest(): void
    {
        $digest = Digest::factory()->create();

        $response = $this->delete(route('digests.destroy', $digest));

        $response->assertRedirect(route('login'));
    }

    public function test_users_can_delete_their_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete(route('digests.destroy', $digest));

        $response->assertRedirect(route('digests.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('digests', [
            'id' => $digest->id,
        ]);
    }

    public function test_users_cannot_delete_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $response = $this->actingAs($user)->delete(route('digests.destroy', $digest));

        $response->assertStatus(403);

        $this->assertDatabaseHas('digests', [
            'id' => $digest->id,
        ]);
    }

    public function test_deleting_digest_cascades_to_pivot_table(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create();
        $digest->items()->attach($item, ['order' => 1]);

        $this->assertDatabaseHas('digest_item', [
            'digest_id' => $digest->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)->delete(route('digests.destroy', $digest));

        $this->assertDatabaseMissing('digest_item', [
            'digest_id' => $digest->id,
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
        ]);
    }

    public function test_users_can_publish_their_own_draft_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create([
            'status' => 'draft',
            'published_at' => null,
        ]);

        $response = $this->actingAs($user)->post(route('digests.publish', $digest));

        $response->assertRedirect(route('digests.show', $digest));
        $response->assertSessionHas('success', 'Digest published successfully.');

        $digest->refresh();
        $this->assertEquals('published', $digest->status);
        $this->assertNotNull($digest->published_at);
    }

    public function test_users_can_unpublish_their_own_published_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->published()->create();

        $response = $this->actingAs($user)->post(route('digests.unpublish', $digest));

        $response->assertRedirect(route('digests.show', $digest));
        $response->assertSessionHas('success', 'Digest unpublished successfully.');

        $digest->refresh();
        $this->assertEquals('draft', $digest->status);
        $this->assertNull($digest->published_at);
    }

    public function test_users_cannot_publish_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create(['status' => 'draft']);

        $response = $this->actingAs($user)->post(route('digests.publish', $digest));

        $response->assertStatus(403);

        $digest->refresh();
        $this->assertEquals('draft', $digest->status);
        $this->assertNull($digest->published_at);
    }

    public function test_users_cannot_unpublish_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->published()->create();

        $response = $this->actingAs($user)->post(route('digests.unpublish', $digest));

        $response->assertStatus(403);

        $digest->refresh();
        $this->assertEquals('published', $digest->status);
        $this->assertNotNull($digest->published_at);
    }

    public function test_guests_cannot_publish_digest(): void
    {
        $digest = Digest::factory()->create(['status' => 'draft']);

        $response = $this->post(route('digests.publish', $digest));

        $response->assertRedirect(route('login'));
    }

    public function test_guests_cannot_unpublish_digest(): void
    {
        $digest = Digest::factory()->published()->create();

        $response = $this->post(route('digests.unpublish', $digest));

        $response->assertRedirect(route('login'));
    }
}
