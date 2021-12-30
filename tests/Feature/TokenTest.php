<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_create_api_token_unauthenticated_redirects_to_login()
    {
        $response = $this->post('/tokens/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_post_create_api_token()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->followingRedirects()->post('/tokens/create');
        $response->assertStatus(200);
        $response->assertSeeText('API token « ');
        $response->assertSeeText(' » created successfully.');

        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'api_token']);
    }

    public function test_post_revoke_all_tokens_unauthenticated_redirects_to_login()
    {
        $response = $this->post('/tokens/revokeall');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_post_revoke_all_tokens()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->followingRedirects()->post('/tokens/create');
        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'api_token']);

        $response = $this->followingRedirects()->post('/tokens/revokeall');
        $response->assertStatus(200);
        $response->assertSeeText('All ');
        $response->assertSeeText(' API tokens revoked successfully.');

        $this->assertDatabaseMissing('personal_access_tokens', ['name' => 'api_token']);
    }
}
