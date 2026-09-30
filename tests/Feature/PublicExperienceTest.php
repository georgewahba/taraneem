<?php

namespace Tests\Feature;

use App\Models\Taraneem;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_english_and_have_no_administration_links(): void
    {
        foreach (['/', '/browseall', '/player', '/suggestion'] as $path) {
            $this->get($path)->assertOk()
                ->assertSee('<html lang="en">', false)
                ->assertDontSee('href="'.route('login').'"', false)
                ->assertDontSee('href="'.route('dashboard').'"', false);
        }
    }

    public function test_library_displays_titles_and_presentation_links(): void
    {
        $hymn = Taraneem::create(['titel' => 'Amazing Grace', 'lyrics' => 'First line@Second line#Next verse']);

        $this->get('/browseall')->assertOk()->assertSee('Amazing Grace')
            ->assertSee(route('taraneem.show', $hymn));
        $this->get(route('taraneem.show', $hymn))->assertOk()
            ->assertSee('Next slide')->assertSee('Enter fullscreen')->assertSee('lyric-data');
    }

    public function test_empty_music_and_populated_music_pages_render(): void
    {
        $this->get('/player')->assertOk()->assertSee('No tracks have been added yet.');
        Track::create(['title' => 'Evening Hymn', 'artist' => 'The Choir', 'file' => 'tracks/evening.ogg']);

        $this->get('/player')->assertOk()->assertSee('Evening Hymn')->assertSee('The Choir')
            ->assertSee('tracks/evening.ogg')->assertDontSee('type="audio/mpeg"', false);
    }

    public function test_unknown_hymns_return_not_found(): void
    {
        $this->get('/tarnima/999999')->assertNotFound();
    }

    public function test_suggestions_are_saved_without_external_mail_in_tests(): void
    {
        $this->post('/storesuggestion', ['titel' => 'New hymn', 'lyrics' => 'Suggested words'])
            ->assertRedirect(route('home'))->assertSessionHas('success', 'Your suggestion has been received. Thank you!');
        $this->assertDatabaseHas('suggestions', ['titel' => 'New hymn', 'lyrics' => 'Suggested words']);
        $this->get('/')->assertSee('Your suggestion has been received. Thank you!');
    }

    public function test_suggestions_validate_strings_and_title_length(): void
    {
        $this->from('/suggestion')->post('/storesuggestion', ['titel' => ['invalid'], 'lyrics' => 'Words'])
            ->assertRedirect('/suggestion')->assertSessionHasErrors('titel');
        $this->post('/storesuggestion', ['titel' => str_repeat('x', 256), 'lyrics' => 'Words'])
            ->assertSessionHasErrors('titel');
        $this->post('/storesuggestion', ['titel' => 'Title', 'lyrics' => ''])->assertSessionHasErrors('lyrics');
        $this->assertDatabaseCount('suggestions', 0);
    }
}
