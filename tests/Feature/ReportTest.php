<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_report_and_sends_email_with_pdf()
    {
        // Create a new profile
        $profile = Profile::factory()->create();

        // Set up a mock function for sending emails
        Mail::shouldReceive('to')
            ->with('your-email@example.com')
            ->andReturn(Mockery::mock(['send' => true]));

        // Send a request to create a new report
        $response = $this->post('/reports', [
            'title' => 'My Report',
            'description' => 'Description of my report',
            'profile_ids' => [$profile->id],
        ]);

        // Check that the report was created successfully
        $response->assertStatus(201);
        $this->assertDatabaseHas('reports', [
            'title' => 'My Report',
            'description' => 'Description of my report',
        ]);
        $this->assertDatabaseHas('profile_report', [
            'report_id' => Report::first()->id,
            'profile_id' => $profile->id,
        ]);

        // Check that the email was sent successfully
        Mail::assertSent(function ($mail) use ($profile) {
            return $mail->hasAttachments() &&
                $mail->to[0]['address'] === 'your-email@example.com' &&
                $mail->hasTo($profile->email);
        });
    }
}
