<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Report;
use App\Models\Profile;

class ReportApiControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        $reports = Report::factory()->count(3)->create();
        $response = $this->getJson('/api/v1/reports');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function testStore()
    {
        $data = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph()
        ];

        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf');

        $response = $this->postJson('/api/v1/reports', [
            'title' => $data['title'],
            'description' => $data['description'],
            'document' => $file
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);

        $report = Report::where('title', $data['title'])->first();
        Storage::disk('public')->assertExists($report->document_path);
    }

    public function testShow()
    {
        $report = Report::factory()->create();
        $response = $this->getJson("/api/v1/reports/{$report->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $report->title]);
    }

    public function testUpdate()
    {
        $report = Report::factory()->create();
        $data = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph()
        ];

        $response = $this->putJson("/api/v1/reports/{$report->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);

        $report = Report::find($report->id);
        $this->assertEquals($data['title'], $report->title);
    }

    public function testDestroy()
    {
        $report = Report::factory()->create();
        $response = $this->deleteJson("/api/v1/reports/{$report->id}");
        $response->assertStatus(204);
        $this->assertNull(Report::find($report->id));
    }

    public function testCreateProfile()
    {
        $report = Report::factory()->create();
        $profileData = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'dob' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female'])
        ];
        $response = $this->postJson("/api/v1/reports/{$report->id}/profiles", $profileData);
        $response->assertStatus(201);
        $response->assertJsonFragment($profileData);
        $this->assertTrue($report->profiles()->where('first_name', $profileData['first_name'])->exists());
    }
}
