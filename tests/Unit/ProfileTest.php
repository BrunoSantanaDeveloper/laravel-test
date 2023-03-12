<?php

namespace Tests\Unit;

use App\Models\Profile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_create_a_profile()
    {
        $profile = Profile::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-01',
            'gender' => 'male'
        ]);

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-01',
            'gender' => 'male'
        ]);
    }

    /** @test */
    public function it_can_update_a_profile()
    {
        $profile = Profile::factory()->create();

        $profile->update([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'dob' => '1991-01-01',
            'gender' => 'female'
        ]);

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'dob' => '1991-01-01',
            'gender' => 'female'
        ]);
    }

    /** @test */
    public function it_can_delete_a_profile()
    {
        $profile = Profile::factory()->create();

        $profile->delete();

        $this->assertDatabaseMissing('profiles', ['id' => $profile->id]);
    }

    /** @test */
    public function it_can_list_all_profiles()
    {
        $profiles = Profile::factory()->count(3)->create();

        $response = $this->get('/profiles');

        foreach ($profiles as $profile) {
            $response->assertSee($profile->first_name);
            $response->assertSee($profile->last_name);
            $response->assertSee($profile->dob);
            $response->assertSee($profile->gender);
        }
    }

    /** @test */
    public function it_validates_required_fields_when_creating_a_profile()
    {
        $response = $this->post('/profiles', []);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'dob', 'gender']);
    }

    /** @test */
    public function it_validates_dob_format_when_creating_a_profile()
    {
        $response = $this->post('/profiles', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => 'invalid',
            'gender' => 'male'
        ]);

        $response->assertSessionHasErrors(['dob']);
    }
}
