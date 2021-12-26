<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Farm;
use App\Models\DataPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    private function create_user_and_farm_with_datapoints() {
        $user = User::factory()->create();
        $farm = Farm::factory()->create(['user_id' => $user->id]);
        DataPoint::factory()->create([
            'farm_id' => $farm->id,
            'datetime' => '2021-01-01 00:00:01',
            'sensortype' => 'temperature',
            'value' => '12.34'
        ]);
        DataPoint::factory()->create([
            'farm_id' => $farm->id,
            'datetime' => '2021-01-01 00:00:01',
            'sensortype' => 'pH',
            'value' => '1.23'
        ]);
        DataPoint::factory()->create([
            'farm_id' => $farm->id,
            'datetime' => '2021-01-01 00:00:01',
            'sensortype' => 'rainFall',
            'value' => '12.34'
        ]);

        return array($user, $farm);
    }

    public function test_get_location_unauthenticated_redirects_to_login()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $response = $this->get("/locations/$farm->id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_get_location_authenticated()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->get("/locations/$farm->id");
        $response->assertStatus(200);
        $response->assertSeeText($farm->location);
        $response->assertSeeText('12.34 °C');
        $response->assertSeeText('pH 1.23');
        $response->assertSeeText('12.34 mm');
    }

    public function test_delete_location_unauthenticated_redirects_to_login()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $response = $this->delete("/locations/$farm->id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_delete_location_authenticated()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->followingRedirects()->delete("/locations/$farm->id");
        $response->assertStatus(200);
        $response->assertSeeText("Location $farm->location removed successfully.");
    }

    public function test_data_points_location_unauthenticated_redirects_to_login()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $response = $this->get("/locations/$farm->id/datapoints");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_data_points_location()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->get("/locations/$farm->id/datapoints");
        $response->assertStatus(200);
        $response->assertSeeText($farm->location);
        $response->assertSeeText('12.34');
        $response->assertSeeText('1.23');
        $response->assertSeeText('12.34');
    }
}
