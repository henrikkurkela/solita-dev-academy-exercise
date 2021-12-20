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
    }
}
