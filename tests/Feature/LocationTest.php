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

    public function test_get_location_unauthenticated_redirects_to_login()
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->create(['user_id' => $user->id]);

        $response = $this->get("/location/$farm->id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_get_location_authenticated()
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

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->get("/location/$farm->id");
        $response->assertStatus(200);
        $response->assertSeeText($farm->location);
        $response->assertSeeText('12.34 °C');
        $response->assertSeeText('pH 1.23');
        $response->assertSeeText('12.34 mm');
    }
}
