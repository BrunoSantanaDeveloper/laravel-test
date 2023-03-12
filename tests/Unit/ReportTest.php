<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Models\Report;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_create_a_report()
    {
        $report = Report::factory()->create([
            'title' => 'Test Report',
            'description' => 'This is a test report'
        ]);

        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'title' => 'Test Report',
            'description' => 'This is a test report'
        ]);
    }

    /** @test */
    public function it_can_update_a_report()
    {
        $report = Report::factory()->create();

        $report->update([
            'title' => 'New Test Report',
            'description' => 'This is a new test report'
        ]);

        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
            'title' => 'New Test Report',
            'description' => 'This is a new test report'
        ]);
    }

    /** @test */
    public function it_can_delete_a_report()
    {
        $report = Report::factory()->create();

        $report->delete();

        $this->assertDatabaseMissing('reports', ['id' => $report->id]);
    }

    /** @test */
    public function it_can_list_all_reports()
    {
        $reports = Report::factory()->count(3)->create();

        $response = $this->get('/reports');

        foreach ($reports as $report) {
            $response->assertSee($report->title);
            $response->assertSee($report->description);
        }
    }

    /** @test */
    public function it_can_associate_profiles_to_a_report()
    {
        $report = Report::factory()->create();
        $profiles = Profile::factory()->count(2)->create();

        $report->profiles()->attach($profiles);

        $this->assertCount(2, $report->profiles);
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

    /** @test */
    public function it_validates_required_fields_when_creating_a_report()
    {
        $response = $this->post('/reports', []);

        $response->assertSessionHasErrors(['title', 'description']);
    }
}
