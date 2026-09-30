<?php

namespace Tests\Feature;

use App\Models\Sugestion;
use App\Models\Taraneem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdministrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_cannot_open_administration_pages(): void
    {
        foreach (['/dashboard', '/taraneem', '/addtaraneem', '/suggestedtaraneem', '/tracks', '/tracks/create', '/profile'] as $path) {
            $this->get($path)->assertRedirect(route('login'));
        }
    }

    public function test_visitors_cannot_change_hymns_suggestions_or_music(): void
    {
        $hymn = Taraneem::create(['titel' => 'Protected hymn', 'lyrics' => 'Words']);
        $suggestion = Sugestion::create(['titel' => 'Protected suggestion', 'lyrics' => 'Words']);

        $this->post('/storetaraneem', ['titel' => 'Unauthorised', 'lyrics' => 'Words'])->assertRedirect(route('login'));
        $this->post(route('taraneem.update', $hymn), ['titel' => 'Changed', 'lyrics' => 'Words'])->assertRedirect(route('login'));
        $this->delete(route('taraneem.destroy', $hymn))->assertRedirect(route('login'));
        $this->delete(route('suggestion.destroy', $suggestion))->assertRedirect(route('login'));
        $this->post('/tracks', ['title' => 'Unauthorised'])->assertRedirect(route('login'));
        $this->assertDatabaseHas('taraneem', ['titel' => 'Protected hymn']);
        $this->assertDatabaseCount('taraneem', 1);
        $this->assertDatabaseCount('suggestions', 1);
        $this->assertDatabaseCount('tracks', 0);
    }

    public function test_staff_can_create_edit_present_and_delete_a_hymn(): void
    {
        $this->actingAs(User::factory()->create());
        $this->get('/addtaraneem')->assertOk()->assertSee('Add a hymn');
        $this->post('/storetaraneem', ['titel' => 'Test hymn', 'lyrics' => 'First@Second#Third'])->assertRedirect('/taraneem');
        $hymn = Taraneem::firstOrFail();
        $this->get(route('taraneem.edit', $hymn))->assertOk()->assertSee('Test hymn');
        $this->post(route('taraneem.update', $hymn), ['titel' => 'Updated hymn', 'lyrics' => 'Updated words'])->assertRedirect('/taraneem');
        $this->get(route('taraneem.show', $hymn))->assertOk()->assertSee('Updated hymn');
        $this->delete(route('taraneem.destroy', $hymn))->assertRedirect('/taraneem');
        $this->assertDatabaseCount('taraneem', 0);
    }

    public function test_invalid_hymn_changes_do_not_overwrite_saved_words(): void
    {
        $hymn = Taraneem::create(['titel' => 'Original title', 'lyrics' => 'Original words']);
        $this->actingAs(User::factory()->create());
        $this->from(route('taraneem.edit', $hymn))->post(route('taraneem.update', $hymn), ['titel' => '', 'lyrics' => ''])
            ->assertSessionHasErrors(['titel', 'lyrics']);
        $this->assertDatabaseHas('taraneem', ['titel' => 'Original title', 'lyrics' => 'Original words']);
    }

    public function test_staff_can_review_and_delete_a_suggestion(): void
    {
        $suggestion = Sugestion::create(['titel' => 'A suggestion', 'lyrics' => 'Suggested words']);
        $this->actingAs(User::factory()->create());
        $this->get('/suggestedtaraneem')->assertOk()->assertSee('A suggestion');
        $this->get(route('showsuggested', $suggestion))->assertOk()->assertSee('Suggested words')->assertSee('readonly');
        $this->delete(route('suggestion.destroy', $suggestion))->assertRedirect('/suggestedtaraneem');
        $this->assertDatabaseCount('suggestions', 0);
    }
}
