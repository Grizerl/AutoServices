<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarInquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarCatalogTest extends TestCase
{
    use RefreshDatabase;

    private function car(array $overrides = []): Car
    {
        return Car::create(array_merge([
            'brand' => 'Hyundai',
            'model' => 'Santro',
            'year' => 2019,
            'mileage' => 54000,
            'price' => 9500,
            'old_price' => null,
            'fuel' => 'petrol',
            'transmission' => 'manual',
            'color' => 'Silver',
            'description' => 'One owner car.',
            'image' => 'assets/auto-sale/car1.jpg',
            'status' => Car::STATUS_AVAILABLE,
            'is_featured' => false,
        ], $overrides));
    }

    // ------------------------------------------------------------ catalog

    public function test_catalog_lists_cars_with_prices_and_links(): void
    {
        $car = $this->car(['old_price' => 10500]);

        $this->get(route('offer'))
            ->assertOk()
            ->assertSee('Hyundai Santro')
            ->assertSee('$9,500')
            ->assertSee('$10,500')           // crossed-out old price
            ->assertSee('-10%')              // discount badge
            ->assertSee(route('car.show', $car), false);
    }

    public function test_empty_catalog_shows_a_friendly_message(): void
    {
        $this->get(route('offer'))->assertOk()->assertSee('No cars for sale right now');
    }

    public function test_catalog_filters_by_brand_fuel_transmission_and_price(): void
    {
        $this->car(['brand' => 'Hyundai', 'model' => 'Santro', 'price' => 9500]);
        $this->car(['brand' => 'Toyota', 'model' => 'Corolla', 'price' => 15000, 'fuel' => 'hybrid', 'transmission' => 'automatic']);

        $this->get(route('offer', ['brand' => 'Toyota']))->assertSee('Toyota Corolla')->assertDontSee('Hyundai Santro');
        $this->get(route('offer', ['fuel' => 'hybrid']))->assertSee('Toyota Corolla')->assertDontSee('Hyundai Santro');
        $this->get(route('offer', ['transmission' => 'manual']))->assertSee('Hyundai Santro')->assertDontSee('Toyota Corolla');
        $this->get(route('offer', ['max_price' => 10000]))->assertSee('Hyundai Santro')->assertDontSee('Toyota Corolla');
        $this->get(route('offer', ['q' => 'coro']))->assertSee('Toyota Corolla')->assertDontSee('Hyundai Santro');
    }

    public function test_no_results_message_when_filters_match_nothing(): void
    {
        $this->car();

        $this->get(route('offer', ['brand' => 'Ferrari']))->assertOk()->assertSee('No cars match your filters');
    }

    public function test_available_only_filter_hides_sold_and_reserved_cars(): void
    {
        $this->car(['model' => 'Alpha']);
        $this->car(['model' => 'Bravo', 'status' => Car::STATUS_SOLD]);
        $this->car(['model' => 'Charlie', 'status' => Car::STATUS_RESERVED]);

        $this->get(route('offer'))->assertSee('Alpha')->assertSee('Bravo')->assertSee('Charlie');
        $this->get(route('offer', ['status' => 'available']))->assertSee('Alpha')->assertDontSee('Bravo')->assertDontSee('Charlie');
    }

    public function test_catalog_sorting(): void
    {
        $this->car(['model' => 'Cheap', 'price' => 5000]);
        $this->car(['model' => 'Pricey', 'price' => 20000]);

        $this->get(route('offer', ['sort' => 'price_asc']))->assertSeeInOrder(['Cheap', 'Pricey']);
        $this->get(route('offer', ['sort' => 'price_desc']))->assertSeeInOrder(['Pricey', 'Cheap']);
    }

    public function test_unknown_filter_values_are_ignored_instead_of_failing(): void
    {
        $this->car();

        $this->get(route('offer', ['fuel' => 'rocket', 'sort' => 'nonsense', 'max_price' => 'abc']))
            ->assertOk()
            ->assertSee('Hyundai Santro');
    }

    public function test_catalog_is_paginated(): void
    {
        foreach (range(1, 12) as $i) {
            $this->car(['model' => "Model{$i}"]);
        }

        $this->get(route('offer'))->assertOk()->assertSee('Showing 1–9 of 12 cars');
        $this->get(route('offer', ['page' => 2]))->assertOk()->assertSee('Showing 10–12 of 12 cars');
    }

    // ------------------------------------------------------------ car page

    public function test_car_page_shows_details(): void
    {
        $car = $this->car(['old_price' => 10500]);

        $this->get(route('car.show', $car))
            ->assertOk()
            ->assertSee('Hyundai Santro')
            ->assertSee('54,000 km')
            ->assertSee('One owner car.')
            ->assertSee('Request this car');
    }

    public function test_unknown_car_returns_404(): void
    {
        $this->get(route('car.show', 9999))->assertNotFound();
    }

    public function test_sold_car_page_has_no_request_form(): void
    {
        $car = $this->car(['status' => Car::STATUS_SOLD]);

        $this->get(route('car.show', $car))->assertOk()->assertSee('This car has been sold')->assertDontSee('Send request');
    }

    // ------------------------------------------------------------ inquiries

    private function inquiry(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Mary Jones',
            'phone' => '+380 95 066 09 59',
            'email' => 'mary@example.com',
            'message' => 'Can I see it on Saturday?',
            'consent' => '1',
        ], $overrides);
    }

    public function test_a_guest_can_request_a_car(): void
    {
        $car = $this->car();

        $this->post(route('car.inquire', $car), $this->inquiry())
            ->assertRedirect(route('car.show', $car).'#request')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('car_inquiries', [
            'car_id' => $car->id,
            'name' => 'Mary Jones',
            'phone' => '+380 95 066 09 59',
            'status' => CarInquiry::STATUS_NEW,
        ]);
    }

    public function test_success_message_is_displayed_after_the_request(): void
    {
        $car = $this->car();

        $this->followingRedirects()->post(route('car.inquire', $car), $this->inquiry())->assertSee('Your request has been sent');
    }

    public function test_email_and_message_are_optional(): void
    {
        $car = $this->car();

        $this->post(route('car.inquire', $car), $this->inquiry(['email' => '', 'message' => '']))->assertSessionHasNoErrors();
        $this->assertDatabaseHas('car_inquiries', ['car_id' => $car->id, 'email' => null, 'message' => null]);
    }

    public function test_inquiry_is_validated(): void
    {
        $car = $this->car();
        $data = $this->inquiry(['name' => '', 'phone' => 'abc', 'email' => 'nope']);
        unset($data['consent']);

        $this->post(route('car.inquire', $car), $data)
            ->assertRedirect(route('car.show', $car).'#request')
            ->assertSessionHasErrors(['name', 'phone', 'email', 'consent']);

        $this->assertDatabaseCount('car_inquiries', 0);
    }

    public function test_a_sold_car_cannot_be_requested(): void
    {
        $car = $this->car(['status' => Car::STATUS_SOLD]);

        $this->post(route('car.inquire', $car), $this->inquiry())->assertSessionHasErrors('car');
        $this->assertDatabaseCount('car_inquiries', 0);
    }

    public function test_a_reserved_car_can_still_be_requested(): void
    {
        $car = $this->car(['status' => Car::STATUS_RESERVED]);

        $this->post(route('car.inquire', $car), $this->inquiry())->assertSessionHas('success');
        $this->assertDatabaseCount('car_inquiries', 1);
    }

    public function test_inquiry_form_is_rate_limited(): void
    {
        $car = $this->car();

        for ($i = 0; $i < 10; $i++) {
            $this->post(route('car.inquire', $car), $this->inquiry());
        }

        $this->post(route('car.inquire', $car), $this->inquiry())->assertStatus(429);
    }

    public function test_default_order_puts_available_cars_first_and_sold_last(): void
    {
        $this->car(['model' => 'SoldOne', 'status' => Car::STATUS_SOLD]);
        $this->car(['model' => 'ReservedOne', 'status' => Car::STATUS_RESERVED]);
        $this->car(['model' => 'AvailableOne']);

        $this->get(route('offer'))->assertSeeInOrder(['AvailableOne', 'ReservedOne', 'SoldOne']);
    }

    public function test_home_page_features_available_cars_with_a_link_to_the_catalog(): void
    {
        $this->car(['model' => 'FeaturedOne', 'is_featured' => true]);
        $this->car(['model' => 'SoldFeatured', 'is_featured' => true, 'status' => Car::STATUS_SOLD]);

        $this->get(route('home_auto'))
            ->assertOk()
            ->assertSee('FeaturedOne')
            ->assertDontSee('SoldFeatured')
            ->assertSee('See all cars')
            ->assertSee(route('offer'), false);
    }

    public function test_home_page_hides_the_cars_block_when_there_are_none(): void
    {
        $this->get(route('home_auto'))->assertOk()->assertDontSee('See all cars');
    }

    public function test_discount_percent_is_computed_from_the_old_price(): void
    {
        $this->assertSame(10, $this->car(['price' => 9000, 'old_price' => 10000])->discount_percent);
        $this->assertNull($this->car(['price' => 9000, 'old_price' => null])->discount_percent);
        $this->assertNull($this->car(['price' => 9000, 'old_price' => 8000])->discount_percent);
    }
}
