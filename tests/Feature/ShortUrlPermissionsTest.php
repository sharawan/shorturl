<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortUrlPermissionsTest extends TestCase
{

use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // home route is protected by auth; sign in a basic user
        $user = $this->createUser();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    protected function createUser($role = 'member')
    {
        // ensure the user belongs to a company so filtering works
        $company = \App\Models\Company::factory()->create();
        return \App\Models\User::factory()->create([
            'role' => $role,
            'company_id' => $company->id,
        ]);
    }

    public function test_super_admin_can_view_all_short_urls()
    {
        $superAdmin = $this->createUser('super_admin');
        $response = $this->actingAs($superAdmin)->get('/short-urls');
        $response->assertStatus(200);
        // Additional assertions to check if all short URLs are visible
    }

    public function test_admin_can_view_company_short_urls()
    {
        $admin = $this->createUser('admin');
        $response = $this->actingAs($admin)->get('/short-urls');
        $response->assertStatus(200);
        // Additional assertions to check if only company short URLs are visible
    }

    public function test_member_can_view_own_short_urls()
    {
        $member = $this->createUser('member');
        $response = $this->actingAs($member)->get('/short-urls');
        $response->assertStatus(200);
        // Additional assertions to check if only own short URLs are visible
    }

    public function test_member_cannot_view_other_users_short_urls()
    {
        $member1 = $this->createUser('member');
        $member2 = $this->createUser('member');
        
        // Create a short URL for member1
        \App\Models\ShortUrl::factory()->create([
            'user_id' => $member1->id,
            'company_id' => $member1->company_id,
        ]);

        // Create a short URL for member2
        \App\Models\ShortUrl::factory()->create([
            'user_id' => $member2->id,
            'company_id' => $member2->company_id,
        ]);

        // Acting as member1, try to access member2's short URLs
        $response = $this->actingAs($member1)->get('/short-urls');
        $response->assertStatus(200);
        // Additional assertions to check if member1 cannot see member2's short URLs
        $response->assertDontSee($member2->name);
    }

    public function test_admin_cannot_view_other_company_short_urls()
    {
        $admin1 = $this->createUser('admin');
        $admin2 = $this->createUser('admin');
        
        // Create a short URL for admin1's company
        \App\Models\ShortUrl::factory()->create([
            'user_id' => $admin1->id,
            'company_id' => $admin1->company_id,
        ]);

        // Create a short URL for admin2's company
        \App\Models\ShortUrl::factory()->create([
            'user_id' => $admin2->id,
            'company_id' => $admin2->company_id,
        ]);
        
        // Acting as admin1, try to access admin2's short URLs
        $response = $this->actingAs($admin1)->get('/short-urls');
        $response->assertStatus(200);
        // Additional assertions to check if admin1 cannot see admin2's short URLs
        $response->assertDontSee($admin2->name);
    }
    public function test_super_admin_can_not_create_short_urls()
    {
        $superAdmin = $this->createUser('super_admin');
        $response = $this->actingAs($superAdmin)->post('/short-urls', [
            'long_url' => 'https://example.com',
        ]);
        $response->assertStatus(403);
    }
}
