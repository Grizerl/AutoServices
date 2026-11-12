<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Repair;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFormsTest extends TestCase
{
    use RefreshDatabase;

    private function booking(array $overrides = []): array
    {
        return array_merge([
            'name' => 'John Smith',
            'phone' => '+380 95 066 09 59',
            'car' => 'Toyota Camry 2015',
            'comment' => 'Strange noise from the engine',
        ], $overrides);
    }

    private function question(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Mary Jones',
            'phone' => '+380950660959',
            'email' => 'mary@example.com',
            'message' => 'Do you repair hybrids?',
            'consent' => '1',
        ], $overrides);
    }

    // ----------------------------------------------------------- booking form

    public function test_a_guest_can_send_a_repair_request(): void
    {
        $this->post(route('repair.store'), $this->booking())
            ->assertRedirect(route('home_auto').'#contacts')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('repairs', [
            'name' => 'John Smith',
            'telephone' => '+380 95 066 09 59',
            'car' => 'Toyota Camry 2015',
            'done' => Repair::STATUS_PENDING,
            'price' => 0,
        ]);
    }

    public function test_repair_request_is_validated(): void
    {
        $this->from(route('home_auto'))
            ->post(route('repair.store'), $this->booking(['name' => '', 'phone' => 'abc', 'car' => '', 'comment' => 'x']))
            ->assertRedirect(route('home_auto').'#contacts')
            ->assertSessionHasErrors(['name', 'phone', 'car', 'comment']);

        $this->assertDatabaseCount('repairs', 0);
    }

    public function test_success_message_is_displayed_after_booking(): void
    {
        $this->followingRedirects()
            ->post(route('repair.store'), $this->booking())
            ->assertSee('Your request has been sent');
    }

    public function test_validation_errors_and_old_input_are_displayed(): void
    {
        $this->followingRedirects()
            ->post(route('repair.store'), $this->booking(['phone' => 'nope']))
            ->assertSee('Please enter a valid phone number')
            ->assertSee('John Smith');
    }

    public function test_booking_form_is_rate_limited(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->post(route('repair.store'), $this->booking());
        }

        $this->post(route('repair.store'), $this->booking())->assertStatus(429);
    }

    // ----------------------------------------------------------- contact form

    public function test_a_guest_can_ask_a_question(): void
    {
        $this->post(route('contact.store'), $this->question())
            ->assertRedirect(route('contacts').'#ask-question')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contacts', ['name' => 'Mary Jones', 'phone' => '+380950660959', 'email' => 'mary@example.com']);
    }

    public function test_email_is_optional(): void
    {
        $this->post(route('contact.store'), $this->question(['email' => '']))->assertSessionHasNoErrors();

        $this->assertDatabaseHas('contacts', ['name' => 'Mary Jones', 'email' => null]);
    }

    public function test_consent_is_required(): void
    {
        $data = $this->question();
        unset($data['consent']);

        $this->post(route('contact.store'), $data)->assertSessionHasErrors('consent');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_contact_form_validation(): void
    {
        $this->post(route('contact.store'), $this->question(['name' => '', 'email' => 'not-an-email', 'message' => '', 'phone' => '1']))
            ->assertSessionHasErrors(['name', 'email', 'message', 'phone']);

        $this->assertSame(0, Contact::count());
    }
}
