<?php

namespace Tests\Feature;

use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TrackManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_upload_edit_and_delete_audio_with_its_file(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
        $this->get('/tracks/create')->assertOk();
        $this->post('/tracks', [
            'title' => 'Choir recording',
            'artist' => 'Community choir',
            'file' => UploadedFile::fake()->create('choir.mp3', 64, 'audio/mpeg'),
        ])->assertRedirect(route('tracks.index'))->assertSessionHasNoErrors();

        $track = Track::firstOrFail();
        Storage::disk('public')->assertExists($track->file);
        $this->get(route('tracks.edit', $track))->assertOk()->assertSee('Choir recording');
        $this->put(route('tracks.update', $track), ['title' => 'Updated recording', 'artist' => null])
            ->assertRedirect(route('tracks.index'));
        $this->assertDatabaseHas('tracks', ['title' => 'Updated recording', 'artist' => null]);
        $this->delete(route('tracks.destroy', $track))->assertRedirect(route('tracks.index'));
        Storage::disk('public')->assertMissing($track->file);
        $this->assertDatabaseCount('tracks', 0);
    }

    public function test_non_audio_uploads_are_rejected(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());
        $this->post('/tracks', [
            'title' => 'Invalid upload',
            'file' => UploadedFile::fake()->create('document.pdf', 64, 'application/pdf'),
        ])->assertSessionHasErrors('file');
        $this->assertDatabaseCount('tracks', 0);
    }

    public function test_invalid_edits_preserve_existing_track_metadata(): void
    {
        $track = Track::create(['title' => 'Original title', 'file' => 'tracks/original.wav']);
        $this->actingAs(User::factory()->create());
        $this->put(route('tracks.update', $track), ['title' => ''])->assertSessionHasErrors('title');
        $this->assertDatabaseHas('tracks', ['title' => 'Original title', 'file' => 'tracks/original.wav']);
    }
}
