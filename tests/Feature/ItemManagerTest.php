<?php

namespace Tests\Feature;

use App\Models\Digest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ItemManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_manager_displays_digest_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create(['title' => 'Test Item']);
        $digest->items()->attach($item, ['order' => 0]);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->assertSee('Test Item')
            ->assertSee('1 items');
    }

    public function test_item_manager_shows_empty_state_when_no_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->assertSee('No items in this digest yet')
            ->assertSee('0 items');
    }

    public function test_user_can_add_item_to_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create(['title' => 'Available Item']);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('addItem', $item->id)
            ->assertSee('Available Item');

        $this->assertDatabaseHas('digest_item', [
            'digest_id' => $digest->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_can_remove_item_from_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create(['title' => 'Item to Remove']);
        $digest->items()->attach($item, ['order' => 0]);

        $this->assertDatabaseHas('digest_item', [
            'digest_id' => $digest->id,
            'item_id' => $item->id,
        ]);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('removeItem', $item->id);

        $this->assertDatabaseMissing('digest_item', [
            'digest_id' => $digest->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_user_cannot_add_same_item_twice(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item = Item::factory()->for($user)->create();
        $digest->items()->attach($item, ['order' => 0]);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('addItem', $item->id);

        $this->assertCount(1, $digest->fresh()->items);
    }

    public function test_user_cannot_add_other_users_items(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $otherItem = Item::factory()->for($otherUser)->create();

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('addItem', $otherItem->id);

        $this->assertDatabaseMissing('digest_item', [
            'digest_id' => $digest->id,
            'item_id' => $otherItem->id,
        ]);
    }

    public function test_available_items_excludes_already_added_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $addedItem = Item::factory()->for($user)->create(['title' => 'Already In Digest']);
        $availableItem = Item::factory()->for($user)->create(['title' => 'Not Yet Added']);
        $digest->items()->attach($addedItem, ['order' => 0]);

        $component = Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('openAddModal')
            ->assertSee('Not Yet Added');

        $this->assertCount(1, $digest->items);
        $this->assertTrue($user->items()->where('id', $availableItem->id)->exists());

        $component->call('addItem', $availableItem->id);
        $this->assertCount(2, $digest->fresh()->items);

        $component->call('addItem', $addedItem->id);
        $this->assertCount(2, $digest->fresh()->items);
    }

    public function test_search_filters_available_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        Item::factory()->for($user)->create(['title' => 'Laravel Tutorial']);
        Item::factory()->for($user)->create(['title' => 'Vue.js Guide']);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('openAddModal')
            ->assertSee('Laravel Tutorial')
            ->assertSee('Vue.js Guide')
            ->set('search', 'Laravel')
            ->assertSee('Laravel Tutorial')
            ->assertDontSee('Vue.js Guide');
    }

    public function test_adding_item_sets_correct_order(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item1 = Item::factory()->for($user)->create();
        $item2 = Item::factory()->for($user)->create();
        $item3 = Item::factory()->for($user)->create();

        $component = Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest]);

        $component->call('addItem', $item1->id);
        $component->call('addItem', $item2->id);
        $component->call('addItem', $item3->id);

        $this->assertEquals(0, $digest->items()->where('items.id', $item1->id)->first()->pivot->order);
        $this->assertEquals(1, $digest->items()->where('items.id', $item2->id)->first()->pivot->order);
        $this->assertEquals(2, $digest->items()->where('items.id', $item3->id)->first()->pivot->order);
    }

    public function test_removing_item_reorders_remaining_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item1 = Item::factory()->for($user)->create();
        $item2 = Item::factory()->for($user)->create();
        $item3 = Item::factory()->for($user)->create();

        $digest->items()->attach($item1, ['order' => 0]);
        $digest->items()->attach($item2, ['order' => 1]);
        $digest->items()->attach($item3, ['order' => 2]);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('removeItem', $item2->id);

        $digest->refresh();
        $this->assertEquals(0, $digest->items()->where('items.id', $item1->id)->first()->pivot->order);
        $this->assertEquals(1, $digest->items()->where('items.id', $item3->id)->first()->pivot->order);
    }

    public function test_sort_items_updates_order(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        $item1 = Item::factory()->for($user)->create(['title' => 'First']);
        $item2 = Item::factory()->for($user)->create(['title' => 'Second']);
        $item3 = Item::factory()->for($user)->create(['title' => 'Third']);

        $digest->items()->attach($item1, ['order' => 0]);
        $digest->items()->attach($item2, ['order' => 1]);
        $digest->items()->attach($item3, ['order' => 2]);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->call('sortItems', $item3->id, 0);

        $digest->refresh();
        $items = $digest->items()->orderBy('order')->get();

        $this->assertEquals($item3->id, $items[0]->id);
        $this->assertEquals($item1->id, $items[1]->id);
        $this->assertEquals($item2->id, $items[2]->id);
    }

    public function test_open_modal_shows_available_items(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();
        Item::factory()->for($user)->create(['title' => 'Available for Adding']);

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->assertDontSee('Available for Adding')
            ->call('openAddModal')
            ->assertSet('showAddModal', true);
    }

    public function test_close_modal_clears_search(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        Volt::actingAs($user)
            ->test('digests.item-manager', ['digest' => $digest])
            ->set('showAddModal', true)
            ->set('search', 'something')
            ->call('closeAddModal')
            ->assertSet('showAddModal', false)
            ->assertSet('search', '');
    }
}
