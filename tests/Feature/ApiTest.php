<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Farm;
use App\Models\DataPoint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    private function create_user_with_token_and_farm_with_datapoints()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;
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

        return array($user, $token, $farm);
    }

    public function test_get_user_unauthenticated()
    {
        $response = $this->get('/api/user');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_get_user_authenticated()
    {
        [$user, $token] = $this->create_user_with_token_and_farm_with_datapoints();

        $response = $this->withHeader('Authorization', "Bearer $token")->get('/api/user');

        $response->assertStatus(200);
        $response->assertSeeText($user->name);
        $response->assertSeeText($user->email);
    }

    public function test_get_locations_unauthenticated()
    {
        $response = $this->get('/api/locations');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_get_locations_authenticated()
    {
        [$userOne, $tokenOne, $farmOne] = $this->create_user_with_token_and_farm_with_datapoints();
        [$userTwo, $tokenTwo, $farmTwo] = $this->create_user_with_token_and_farm_with_datapoints();

        $response = $this->withHeader('Authorization', "Bearer $tokenOne")->get('/api/locations');

        $response->assertStatus(200);
        $response->assertSeeText($farmOne->location);
        $response->assertJsonFragment(['id' => $farmOne->id]);
        $response->assertJsonMissing(['id' => $farmTwo->id]);
    }

    public function test_get_location_by_id_not_owned_authenticated()
    {
        [$userOne, $tokenOne, $farmOne] = $this->create_user_with_token_and_farm_with_datapoints();
        [$userTwo, $tokenTwo, $farmTwo] = $this->create_user_with_token_and_farm_with_datapoints();

        $response = $this->withHeader('Authorization', "Bearer $tokenOne")->get("/api/locations/$farmTwo->id");

        $response->assertStatus(404);
        $response->assertSeeText('Not Found');
    }

    public function test_get_location_by_id_authenticated()
    {
        [$user, $token, $farm] = $this->create_user_with_token_and_farm_with_datapoints();

        $response = $this->withHeader('Authorization', "Bearer $token")->get("/api/locations/$farm->id");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $farm->id]);
        $response->assertJsonFragment(['location' => $farm->location]);
    }

    public function test_post_data_point_unauthenticated()
    {
        [$user, $token, $farm] = $this->create_user_with_token_and_farm_with_datapoints();

        $response = $this->post("/api/locations/{$farm->id}", [
            'value' => 10,
            'sensortype' => 'temperature',
            'datetime' => 2021 - 01 - 01
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_post_data_point_not_owned_authenticated()
    {
        [$userOne, $tokenOne, $farmOne] = $this->create_user_with_token_and_farm_with_datapoints();
        [$userTwo, $tokenTwo, $farmTwo] = $this->create_user_with_token_and_farm_with_datapoints();

        $response = $this->withHeader('Authorization', "Bearer $tokenOne")->post("/api/locations/$farmTwo->id", [
            'value' => '10',
            'sensortype' => 'temperature',
            'datetime' => '2021-01-01'
        ]);

        $response->assertStatus(500);
        $response->assertSeeText('No query results for model');
    }

    public function test_post_data_point_authenticated()
    {
        [$user, $token, $farm] = $this->create_user_with_token_and_farm_with_datapoints();

        $response = $this->withHeader('Authorization', "Bearer $token")->post("/api/locations/$farm->id", [
            'value' => '10',
            'sensortype' => 'temperature',
            'datetime' => '2021-01-01'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['farm_id' => $farm->id]);
        $response->assertJsonFragment(['value' => '10']);
        $response->assertJsonFragment(['sensortype' => 'temperature']);

        $this->assertDatabaseHas('data_points', [
            'value' => 10,
            'sensortype' => 'temperature',
            'farm_id' => $farm->id
        ]);
    }
}
