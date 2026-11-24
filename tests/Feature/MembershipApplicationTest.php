<?php

namespace Tests\Feature;

use App\Models\MembershipCategory;
use App\Notifications\MembershipApplicationSubmitted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MembershipApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_is_stored_and_notification_is_queued(): void
    {
        Notification::fake();
        $category = MembershipCategory::create(['name' => 'Regular', 'description' => 'Standard']);
        $response = $this->post(route('membership.store'), ['membership_category_id' => $category->id, 'full_name' => 'Ana Cruz', 'email' => 'ana@example.test', 'latitude' => 14.5995, 'longitude' => 120.9842]);
        $response->assertRedirect(route('membership.create'));
        $this->assertDatabaseHas('membership_applications', ['email' => 'ana@example.test', 'status' => 'pending']);
        Notification::assertSentOnDemand(MembershipApplicationSubmitted::class);
    }
}
