<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Members;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_the_site(): void
    {
        $this->get('/')->assertRedirect('/AutoStyle');
    }

    #[DataProvider('pages')]
    public function test_public_pages_render(string $url): void
    {
        $this->get($url)->assertOk();
    }

    public static function pages(): array
    {
        return [
            ['/AutoStyle'],
            ['/AutoStyle/About/News'],
            ['/AutoStyle/About/History'],
            ['/AutoStyle/Contacts/Detailed'],
            ['/AutoStyle/Pages/Offer'],
            ['/AutoStyle/Pages/Pricing/Plan'],
            ['/AutoStyle/Pages/Partners'],
            ['/login'],
        ];
    }

    public function test_home_page_renders_with_an_empty_database(): void
    {
        // used to redirect back to itself in an endless loop
        $this->get('/AutoStyle')->assertOk();
    }

    public function test_home_page_shows_content_from_the_database(): void
    {
        Post::create(['title' => 'Welcome to the garage', 'content' => 'We fix cars.']);
        Client::create(['name' => 'Jane Doe', 'role' => 'Owner of Audi A4', 'commentars' => 'Great service']);
        Members::create([
            'name' => 'Tom Smith', 'role' => 'Mechanic', 'age' => 30, 'phone_number' => '+380501112233',
            'place_of_residence' => 'Kyiv', 'img' => 'assets/people/team-img1.jpg',
        ]);

        $this->get('/AutoStyle')
            ->assertOk()
            ->assertSee('Welcome to the garage')
            ->assertSee('Jane Doe')
            ->assertSee('Tom Smith')
            ->assertSee('assets/people/team-img1.jpg');
    }

    public function test_unknown_page_returns_a_friendly_404(): void
    {
        $this->get('/no-such-page')->assertNotFound()->assertSee('not found');
    }
}
