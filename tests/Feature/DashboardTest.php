<?php

namespace Tests\Feature;

use App\Models\Digest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Atelier éditorial');
        $response->assertSee('Capturer un lien');
        $response->assertSee('Briefs IA');
    }

    public function test_dashboard_shows_user_editorial_workspace_data(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $draftDigest = Digest::factory()->for($user)->create([
            'title' => 'Laravel Weekly',
            'status' => 'draft',
        ]);

        Digest::factory()->for($user)->published()->create([
            'title' => 'Already Shipped',
        ]);

        Digest::factory()->for($otherUser)->create([
            'title' => 'Other User Digest',
        ]);

        $item = Item::factory()->for($user)->create([
            'title' => 'Livewire Patterns',
            'url' => 'https://example.com/livewire-patterns',
        ]);

        Item::factory()->for($otherUser)->create([
            'title' => 'Hidden Source',
            'url' => 'https://example.com/hidden',
        ]);

        $draftDigest->items()->attach($item, ['order' => 0]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('stats', [
            'items' => 1,
            'digests' => 2,
            'drafts' => 1,
            'published' => 1,
        ]);
        $response->assertSee('Laravel Weekly');
        $response->assertSee('Livewire Patterns');
        $response->assertSee('Already Shipped');
        $response->assertDontSee('Other User Digest');
        $response->assertDontSee('Hidden Source');
    }
}
