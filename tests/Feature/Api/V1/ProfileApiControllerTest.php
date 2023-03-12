<?php

namespace Tests\Feature\Api\V1;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileApiControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_a_list_of_profiles()
    {
        $profiles = Profile::factory()->count(3)->create();

        $response = $this->get('/api/v1/profiles');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'first_name', 'last_name', 'dob', 'gender']
                ]
            ]);
    }

    /** @test */
    public function can_create_a_profile()
    {
        $profileData = Profile::factory()->make()->toArray();

        $response = $this->post('/api/v1/profiles', $profileData);

        $response->assertStatus(201)
            ->assertJsonFragment($profileData);

        $this->assertDatabaseHas('profiles', $profileData);
    }

    /** @test */
    public function can_get_a_single_profile()
    {
        $profile = Profile::factory()->create();

        $response = $this->get('/api/v1/profiles/' . $profile->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $profile->id,
                'first_name' => $profile->first_name,
                'last_name' => $profile->last_name,
                'dob' => $profile->dob->format('Y-m-d'),
                'gender' => $profile->gender
            ]);
    }

    /** @test */
    public function can_update_a_profile()
    {
        $profile = Profile::factory()->create();

        $newData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-01',
            'gender' => 'male'
        ];

        $response = $this->put('/api/v1/profiles/' . $profile->id, $newData);

        $response->assertStatus(200)
            ->assertJsonFragment($newData);

        $this->assertDatabaseHas('profiles', $newData);
    }

    /** @test */
    public function can_delete_a_profile()
    {
        $profile = Profile::factory()->create();

        $response = $this->delete('/api/v1/profiles/' . $profile->id);

        $response->assertStatus(204);

        $this->assertDeleted('profiles', $profile->toArray());
    }
}
