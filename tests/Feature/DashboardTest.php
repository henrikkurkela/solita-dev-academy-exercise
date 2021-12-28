<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Farm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_dashboard_unauthenticated_redirects_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_get_dashboard_authenticated()
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->create(['user_id' => $user->id]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSeeText($farm->location);
    }

    public function test_post_measurement_data_unauthenticated_redirects_to_login()
    {
        $response = $this->post('/upload');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_post_measurement_data_authenticated()
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->create([
            'location' => 'Test Location',
            'user_id' => $user->id
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->followingRedirects()->post('/upload', [
            'file' => new UploadedFile(__DIR__ . '/test_measurements.csv', 'null', null, null, true, true)
        ]);
        $response->assertStatus(200);
        $response->assertSeeText('5 measurements were accepted, 1 measurements were rejected.');

        $this->assertDatabaseHas('data_points', [
            'farm_id' => $farm->id,
            'sensortype' => 'pH',
            'value' => '5.88'
        ]);
    }

    public function test_post_create_location_unauthenticated_redirects_to_login()
    {
        $response = $this->post('/locations', [
            'location' => 'New Location'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('farms', ['location' => 'New Location']);
    }

    public function test_post_create_location_authenticated()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->followingRedirects()->post('/locations', [
            'location' => 'New Location'
        ]);
        $response->assertStatus(200);
        $response->assertSeeText('Location New Location created successfully.');

        $this->assertDatabaseHas('farms', [
            'user_id' => $user->id,
            'location' => 'New Location'
        ]);
    }

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
