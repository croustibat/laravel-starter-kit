<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BriefControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_view_briefs_index(): void
    {
        $response = $this->get(route('briefs.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_view_briefs_index(): void
    {
        $user = User::factory()->create();

        Item::factory()->for($user)->create([
            'title' => 'Agentic Publishing',
            'url' => 'https://example.com/agentic-publishing',
        ]);

        $response = $this->actingAs($user)->get(route('briefs.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.briefs.index');
        $response->assertSee('Briefs');
        $response->assertSee('Générer un brouillon éditorial');
        $response->assertSee('Agentic Publishing');
    }
}
