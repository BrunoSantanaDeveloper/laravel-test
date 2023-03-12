<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Models\Report;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReportProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_associate_profiles_to_a_report()
    {
        $report = Report::factory()->create();
        $profiles = Profile::factory()->count(2)->create();

        $report->profiles()->attach($profiles);

        $this->assertCount(2, $report->profiles);
    }

    /** @test */
    public function it_can_remove_associated_profiles_from_a_report()
    {
        $report = Report::factory()->create();
        $profiles = Profile::factory()->count(2)->create();

        $report->profiles()->attach($profiles);

        $report->profiles()->detach($profiles->first());

        $this->assertCount(1, $report->profiles);
    }

    /** @test */
    public function it_can_list_all_profiles_associated_to_a_report()
    {
        $report = Report::factory()->create();
        $profiles = Profile::factory()->count(2)->create();

        $report->profiles()->attach($profiles);

        $response = $this->get('/reports/' . $report->id);

        foreach ($profiles as $profile) {
            $response->assertSee($profile->first_name);
            $response->assertSee($profile->last_name);
            $response->assertSee($profile->dob);
            $response->assertSee($profile->gender);
        }
    }
}
