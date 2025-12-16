<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Hafalan;
use App\Models\VoiceSubmission;

class VoiceSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_voice_submission_store_with_ajax_returns_json()
    {
        // Create a test user
        $user = User::factory()->create(['role' => 'santri']);
        $this->actingAs($user);

        // Create a test hafalan
        $hafalan = Hafalan::factory()->create();

        // Create a mock audio file
        Storage::fake('public');
        $file = UploadedFile::fake()->create('test.mp3', 1000, 'audio/mpeg');

        $response = $this->postJson('/voice-submission', [
            'hafalan_id' => $hafalan->id,
            'voice_file' => $file,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Hafalan berhasil disubmit! Tunggu review dari ustad.',
                     'success' => true
                 ]);

        $this->assertDatabaseHas('voice_submissions', [
            'user_id' => $user->id,
            'hafalan_id' => $hafalan->id,
            'status' => 'pending'
        ]);
    }

    public function test_voice_submission_store_with_validation_error_returns_json()
    {
        // Create a test user
        $user = User::factory()->create(['role' => 'santri']);
        $this->actingAs($user);

        // Create a mock audio file
        Storage::fake('public');
        $file = UploadedFile::fake()->create('test.txt', 1000, 'text/plain'); // Invalid file type

        $response = $this->postJson('/voice-submission', [
            'hafalan_id' => 1, // Invalid hafalan ID
            'voice_file' => $file,
        ]);

        $response->assertStatus(422);
    }

    public function test_voice_submission_store_with_existing_approved_submission_returns_json_error()
    {
        // Create a test user
        $user = User::factory()->create(['role' => 'santri']);
        $this->actingAs($user);

        // Create a test hafalan
        $hafalan = Hafalan::factory()->create();

        // Create an existing approved submission
        VoiceSubmission::factory()->create([
            'user_id' => $user->id,
            'hafalan_id' => $hafalan->id,
            'status' => 'approved'
        ]);

        // Create a mock audio file
        Storage::fake('public');
        $file = UploadedFile::fake()->create('test.mp3', 1000, 'audio/mpeg');

        $response = $this->postJson('/voice-submission', [
            'hafalan_id' => $hafalan->id,
            'voice_file' => $file,
        ]);

        $response->assertStatus(422)
                 ->assertJson([
                     'message' => 'Anda sudah menyelesaikan hafalan ini dengan status disetujui.',
                     'success' => false
                 ]);
    }
    
    public function test_voice_submission_handles_server_errors_gracefully()
    {
        // Test that server errors return proper JSON responses
        $user = User::factory()->create(['role' => 'santri']);
        $this->actingAs($user);

        // Send request without required fields to trigger validation error
        $response = $this->postJson('/voice-submission', []);

        $response->assertStatus(422); // Validation error status
        $response->assertJsonStructure(['message', 'success']); // Should return JSON structure
    }
}