<?php

namespace Tests\Unit;

use App\Models\Digest;
use App\Models\User;
use App\Policies\DigestPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DigestPolicyTest extends TestCase
{
    use RefreshDatabase;

    private DigestPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new DigestPolicy;
    }

    public function test_any_user_can_view_any_digests(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($this->policy->viewAny($user));
    }

    public function test_user_can_view_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $this->assertTrue($this->policy->view($user, $digest));
    }

    public function test_user_cannot_view_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $this->assertFalse($this->policy->view($user, $digest));
    }

    public function test_any_user_can_create_digests(): void
    {
        $user = User::factory()->create();

        $this->assertTrue($this->policy->create($user));
    }

    public function test_user_can_update_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $this->assertTrue($this->policy->update($user, $digest));
    }

    public function test_user_cannot_update_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $this->assertFalse($this->policy->update($user, $digest));
    }

    public function test_user_can_delete_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $this->assertTrue($this->policy->delete($user, $digest));
    }

    public function test_user_cannot_delete_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $this->assertFalse($this->policy->delete($user, $digest));
    }

    public function test_user_can_restore_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $this->assertTrue($this->policy->restore($user, $digest));
    }

    public function test_user_cannot_restore_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $this->assertFalse($this->policy->restore($user, $digest));
    }

    public function test_user_can_force_delete_own_digest(): void
    {
        $user = User::factory()->create();
        $digest = Digest::factory()->for($user)->create();

        $this->assertTrue($this->policy->forceDelete($user, $digest));
    }

    public function test_user_cannot_force_delete_other_users_digest(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $digest = Digest::factory()->for($otherUser)->create();

        $this->assertFalse($this->policy->forceDelete($user, $digest));
    }
}
