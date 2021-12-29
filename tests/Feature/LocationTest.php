<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Farm;
use App\Models\DataPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    private function create_user_and_farm_with_datapoints()
    {
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

        $this->assertDatabaseHas('farms', $farm->makeHidden(['created_at', 'updated_at'])->toArray());
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

        $this->assertDatabaseMissing('farms', $farm->makeHidden(['created_at', 'updated_at'])->toArray());
    }

    public function test_delete_location_not_owned_authenticated()
    {
        [$userOne, $farmOne] = $this->create_user_and_farm_with_datapoints();
        [$userTwo, $farmTwo] = $this->create_user_and_farm_with_datapoints();

        $response = $this->post('/login', [
            'email' => $userTwo->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->followingRedirects()->delete("/locations/$farmOne->id");
        $response->assertStatus(200);
        $response->assertSeeText("Error!");
        $response->assertSeeText("Error encountered while removing location, try again later.");

        $this->assertDatabaseHas('farms', $farmOne->makeHidden(['created_at', 'updated_at'])->toArray());
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

    public function test_delete_data_point_unauthenticated_redirects_to_login()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $response = $this->delete("/locations/$farm->id/datapoints/{$farm->datapoints()->first()->id}");
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->assertDatabaseHas('data_points', ['id' => $farm->datapoints()->first()->id]);
    }

    public function test_delete_data_point_location_not_owned_authenticated()
    {
        [$userOne, $farmOne] = $this->create_user_and_farm_with_datapoints();
        [$userTwo, $farmTwo] = $this->create_user_and_farm_with_datapoints();

        $response = $this->post('/login', [
            'email' => $userTwo->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->followingRedirects()->delete("/locations/$farmOne->id/datapoints/{$farmOne->datapoints()->first()->id}");
        $response->assertStatus(200);
        $response->assertSeeText("Error!");
        $response->assertSeeText("No query results for model");

        $this->assertDatabaseHas('data_points', ['id' => $farmOne->datapoints()->first()->id]);
    }

    public function test_delete_data_point_authenticated()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();
        $dataPoint = $farm->datapoints()->first();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->get("/locations/$farm->id/datapoints");

        $response = $this->followingRedirects()->delete("/locations/$farm->id/datapoints/$dataPoint->id");
        $response->assertStatus(200);
        $response->assertSeeText('Measurement removed successfully.');

        $this->assertDatabaseMissing('data_points', ['id' => $dataPoint->id]);
    }

    public function test_delete_data_points_unauthenticated_redirects_to_login()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $measurements = $farm->datapoints()->get()->makeHidden(['created_at', 'updated_at'])->toArray();

        $response = $this->delete("/locations/$farm->id/datapoints");
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        foreach ($measurements as $measurement) {
            $this->assertDatabaseHas('data_points', $measurement);
        }
    }

    public function test_delete_data_points_location_not_owned_authenticated()
    {
        [$userOne, $farmOne] = $this->create_user_and_farm_with_datapoints();
        [$userTwo, $farmTwo] = $this->create_user_and_farm_with_datapoints();

        $measurements = $farmOne->datapoints()->get()->makeHidden(['created_at', 'updated_at'])->toArray();

        $response = $this->post('/login', [
            'email' => $userTwo->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->followingRedirects()->delete("/locations/$farmOne->id/datapoints");
        $response->assertStatus(200);
        $response->assertSeeText("Error!");
        $response->assertSeeText("No query results for model");

        foreach ($measurements as $measurement) {
            $this->assertDatabaseHas('data_points', $measurement);
        }
    }

    public function test_delete_data_points_authenticated()
    {
        [$user, $farm] = $this->create_user_and_farm_with_datapoints();

        $measurements = $farm->datapoints()->get()->makeHidden(['created_at', 'updated_at'])->toArray();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $measurementCount = $farm->datapoints()->count();

        $response = $this->followingRedirects()->delete("/locations/$farm->id/datapoints");
        $response->assertStatus(200);
        $response->assertSeeText("Success!");
        $response->assertSeeText("Removed $measurementCount measurements successfully.");

        foreach ($measurements as $measurement) {
            $this->assertDatabaseMissing('data_points', $measurement);
        }
    }
}
