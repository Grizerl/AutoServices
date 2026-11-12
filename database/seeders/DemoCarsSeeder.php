<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

/** Sample cars for sale (bundled photos attached through the media library); only fills an empty table. */
class DemoCarsSeeder extends Seeder
{
    public function run(): void
    {
        if (Car::exists()) {
            return;
        }

        $cars = [
            ['Hyundai', 'Santro BS6', 2019, 54000, 9500, 10500, 'petrol', 'manual', 'Silver', 'available', true,
                'One owner, full service history. New tyres, fresh oil and a complete check by our mechanics. Economical city car with low running costs.'],
            ['Hyundai', 'Santro AMT', 2020, 38000, 11200, 12000, 'petrol', 'automatic', 'White', 'available', true,
                'Automatic transmission makes this a great choice for city traffic. Air conditioning, power windows and a reversing camera.'],
            ['Hyundai', 'Grand i10 Nios', 2021, 21000, 12800, null, 'petrol', 'manual', 'White', 'available', false,
                'Almost new and still under the manufacturer warranty. Touchscreen, rear parking sensors and a spacious interior.'],
            ['Hyundai', 'Aura', 2021, 29000, 10900, 11800, 'lpg', 'manual', 'Blue', 'available', false,
                'Factory-fitted LPG system for very cheap kilometres. Big boot, comfortable ride and a clean service record.'],
            ['Hyundai', 'Grand i10', 2017, 76000, 7400, null, 'petrol', 'manual', 'Red', 'reserved', false,
                'Reliable and easy to park. Timing belt and brakes were replaced recently. Currently reserved by a customer.'],
            ['Hyundai', 'Santro', 2016, 110000, 5900, null, 'petrol', 'manual', 'Grey', 'sold', false,
                'A dependable first car. Already sold; browse our other cars for something similar.'],
        ];

        foreach ($cars as $i => [$brand, $model, $year, $mileage, $price, $oldPrice, $fuel, $transmission, $color, $status, $featured, $description]) {
            $car = Car::create([
                'brand' => $brand,
                'model' => $model,
                'year' => $year,
                'mileage' => $mileage,
                'price' => $price,
                'old_price' => $oldPrice,
                'fuel' => $fuel,
                'transmission' => $transmission,
                'color' => $color,
                'status' => $status,
                'is_featured' => $featured,
                'description' => $description,
            ]);

            // bundled demo photo -> Spatie Media Library (builds the thumb / large conversions)
            $car->addMedia(public_path('assets/auto-sale/car'.($i + 1).'.jpg'))
                ->preservingOriginal()
                ->toMediaCollection(Car::PHOTO);
        }
    }
}
