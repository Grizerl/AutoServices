<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Members;
use App\Models\Post;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        Role::findOrCreate('Admin', 'web');

        return tap(User::factory()->create())->assignRole('Admin');
    }

    // ----------------------------------------------------------- access

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin-home'))->assertRedirect(route('login'));
        $this->get(route('post.index'))->assertRedirect(route('login'));
    }

    public function test_regular_users_cannot_open_the_admin_panel(): void
    {
        $this->actingAs(User::factory()->create())->get(route('admin-home'))->assertForbidden();
    }

    public function test_admin_sees_the_dashboard_and_all_sections(): void
    {
        $this->actingAs($this->admin());

        foreach (['admin-home', 'post.index', 'post.create', 'client.index', 'client.create', 'members.index', 'members.create', 'contact.index', 'repair.index'] as $route) {
            $this->get(route($route))->assertOk();
        }
    }

    public function test_login_redirects_to_an_existing_page(): void
    {
        $admin = $this->admin();
        $admin->update(['password' => 'secret-pass']);

        $this->post('/login', ['email' => $admin->email, 'password' => 'secret-pass'])->assertRedirect('/AdminPanel');
        $this->get('/AdminPanel')->assertRedirect(route('admin-home'));
    }

    public function test_admin_can_log_out_from_the_panel(): void
    {
        $this->actingAs($this->admin())->post(route('logout'))->assertRedirect('/');
        $this->assertGuest();
    }

    // ----------------------------------------------------------- posts

    public function test_admin_can_manage_posts(): void
    {
        $this->actingAs($this->admin());

        $this->post(route('post.store'), ['title' => 'Hello', 'content_post' => 'World'])
            ->assertRedirect(route('post.index'))->assertSessionHas('success');
        $post = Post::firstOrFail();
        $this->assertSame('World', $post->content);

        $this->put(route('post.update', $post), ['title' => 'Hello 2', 'content_post' => 'World 2'])
            ->assertRedirect(route('post.index'));
        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Hello 2']);

        $this->delete(route('post.destroy', $post))->assertRedirect(route('post.index'));
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_post_requires_title_and_content(): void
    {
        $this->actingAs($this->admin())
            ->post(route('post.store'), ['title' => '', 'content_post' => ''])
            ->assertSessionHasErrors(['title', 'content_post']);
    }

    // ----------------------------------------------------------- reviews

    public function test_admin_can_manage_reviews_and_input_is_validated(): void
    {
        $this->actingAs($this->admin());

        $this->post(route('client.store'), ['name' => '', 'role' => '', 'commentars' => ''])
            ->assertSessionHasErrors(['name', 'role', 'commentars']);

        $this->post(route('client.store'), ['name' => 'Jane', 'role' => 'Owner of Audi', 'commentars' => 'Great'])
            ->assertRedirect(route('client.index'));
        $client = Client::firstOrFail();

        $this->put(route('client.update', $client), ['name' => 'Jane D.', 'role' => 'Owner of Audi', 'commentars' => 'Great!'])
            ->assertRedirect(route('client.index'));
        $this->assertSame('Jane D.', $client->fresh()->name);

        $this->delete(route('client.destroy', $client));
        $this->assertDatabaseCount('clients', 0);
    }

    // ----------------------------------------------------------- team members

    private function member(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Tom Smith',
            'phone' => '+380501112233',
            'age' => 31,
            'residence' => 'Kyiv',
            'role' => 'Mechanic',
            'image' => UploadedFile::fake()->image('tom.jpg', 300, 300),
        ], $overrides);
    }

    public function test_member_photo_is_an_uploaded_file(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());

        $this->post(route('members.store'), $this->member())->assertRedirect(route('members.index'));

        $member = Members::firstOrFail();
        $this->assertStringStartsWith('members/', $member->img);
        Storage::disk('uploads')->assertExists($member->img);
    }

    public function test_member_photo_cannot_be_a_link(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());

        $this->post(route('members.store'), $this->member(['image' => 'https://example.com/photo.jpg']))
            ->assertSessionHasErrors('image');
        $this->post(route('members.store'), $this->member(['image' => null]))
            ->assertSessionHasErrors('image');
        $this->post(route('members.store'), $this->member(['image' => UploadedFile::fake()->create('evil.php', 10)]))
            ->assertSessionHasErrors('image');

        $this->assertDatabaseCount('members', 0);
    }

    public function test_updating_a_member_replaces_the_old_photo_and_delete_removes_it(): void
    {
        Storage::fake('uploads');
        $this->actingAs($this->admin());
        $this->post(route('members.store'), $this->member());
        $member = Members::firstOrFail();
        $oldPhoto = $member->img;

        // update without a new photo keeps the old one
        $this->put(route('members.update', $member), $this->member(['name' => 'Tom S.', 'image' => null]))
            ->assertRedirect(route('members.index'));
        $this->assertSame($oldPhoto, $member->fresh()->img);

        // update with a new photo replaces it
        $this->put(route('members.update', $member), $this->member(['image' => UploadedFile::fake()->image('new.png')]));
        $newPhoto = $member->fresh()->img;
        $this->assertNotSame($oldPhoto, $newPhoto);
        Storage::disk('uploads')->assertMissing($oldPhoto);
        Storage::disk('uploads')->assertExists($newPhoto);

        $this->delete(route('members.destroy', $member))->assertRedirect(route('members.index'));
        Storage::disk('uploads')->assertMissing($newPhoto);
        $this->assertDatabaseCount('members', 0);
    }

    public function test_bundled_demo_photos_are_never_deleted(): void
    {
        $this->actingAs($this->admin());
        $member = Members::create([
            'name' => 'Demo', 'role' => 'x', 'age' => 30, 'phone_number' => '+380501112233',
            'place_of_residence' => 'Kyiv', 'img' => 'assets/people/team-img1.jpg',
        ]);

        $this->assertStringContainsString('assets/people/team-img1.jpg', $member->image_url);
        $this->delete(route('members.destroy', $member));
        $this->assertFileExists(public_path('assets/people/team-img1.jpg'));
    }

    public function test_member_form_is_validated(): void
    {
        $this->actingAs($this->admin())
            ->post(route('members.store'), $this->member(['name' => '', 'age' => 'abc', 'phone' => 'x']))
            ->assertSessionHasErrors(['name', 'age', 'phone']);
    }

    // ----------------------------------------------------------- repairs & questions

    public function test_admin_can_process_a_repair_request(): void
    {
        $this->actingAs($this->admin());
        $repair = Repair::create(['name' => 'John', 'telephone' => '+380950660959', 'car' => 'BMW', 'comment' => 'Brakes squeak']);

        $this->get(route('repair.show', $repair))->assertOk()->assertSee('Brakes squeak');

        $this->put(route('repair.update', $repair), [
            'name' => 'John', 'phone' => '+380950660959', 'car' => 'BMW', 'problem' => 'Brakes squeak',
            'price' => 150, 'done' => 'completed',
        ])->assertRedirect(route('repair.index'));

        $this->assertDatabaseHas('repairs', ['id' => $repair->id, 'price' => 150, 'done' => 'completed']);
    }

    public function test_repair_status_must_be_known(): void
    {
        $this->actingAs($this->admin());
        $repair = Repair::create(['name' => 'John', 'telephone' => '+380950660959', 'car' => 'BMW', 'comment' => 'Brakes squeak']);

        $this->put(route('repair.update', $repair), [
            'name' => 'John', 'phone' => '+380950660959', 'car' => 'BMW', 'problem' => 'x',
            'price' => -5, 'done' => 'whatever',
        ])->assertSessionHasErrors(['price', 'done']);
    }

    public function test_admin_can_delete_questions(): void
    {
        $this->actingAs($this->admin());
        $contact = Contact::create(['name' => 'Mary', 'phone' => '+380950660959', 'email' => null, 'message' => 'Hi there']);

        $this->get(route('contact.index'))->assertOk()->assertSee('Hi there');
        $this->delete(route('contact.destroy', $contact))->assertRedirect(route('contact.index'));
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_public_visitors_cannot_use_admin_store_routes(): void
    {
        $this->post(route('post.store'), ['title' => 'x', 'content_post' => 'y'])->assertRedirect(route('login'));
        $this->assertDatabaseCount('posts', 0);
    }
}
