<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Report;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReportProfileViewTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_show_all_reports_and_associated_profiles()
    {
        $report1 = Report::factory()->create();
        $report2 = Report::factory()->create();
        $profile1 = Profile::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);
        $profile2 = Profile::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe'
        ]);
        $profile3 = Profile::factory()->create([
            'first_name' => 'Bob',
            'last_name' => 'Smith'
        ]);

        $report1->profiles()->attach([$profile1->id, $profile2->id]);
        $report2->profiles()->attach($profile3->id);

        $response = $this->get('/reports');

        $response->assertSee($report1->title);
        $response->assertSee($report2->title);

        $response->assertSee($profile1->first_name);
        $response->assertSee($profile1->last_name);
        $response->assertSee($profile2->first_name);
        $response->assertSee($profile2->last_name);
        $response->assertSee($profile3->first_name);
        $response->assertSee($profile3->last_name);
    }
}
