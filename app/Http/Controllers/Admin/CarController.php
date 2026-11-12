<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request): View
    {
        $status = array_key_exists((string) $request->query('status'), Car::STATUSES) ? $request->query('status') : null;

        return view('admin.cars.index', [
            'cars' => Car::query()
                ->with('media')
                ->withCount('inquiries')
                ->when($status, fn ($q, $s) => $q->where('status', $s))
                ->latest('id')
                ->paginate(15)
                ->withQueryString(),
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.cars.create');
    }

    public function store(CarRequest $request): RedirectResponse
    {
        $car = Car::create($request->safe()->except('image'));

        // Spatie Media Library stores the photo and builds the thumb / large conversions
        $car->addMediaFromRequest('image')->toMediaCollection(Car::PHOTO);

        return redirect()->route('cars.index')->with('success', 'The car has been added.');
    }

    public function edit(Car $car): View
    {
        return view('admin.cars.edit', ['car' => $car]);
    }

    public function update(CarRequest $request, Car $car): RedirectResponse
    {
        $data = $request->safe()->except('image');

        $car->update($data);

        if ($request->hasFile('image')) {
            // single-file collection: the previous photo and its conversions are removed
            $car->addMediaFromRequest('image')->toMediaCollection(Car::PHOTO);

            if ($car->image) {
                $car->deleteImageFile(); // legacy upload from before the media library
                $car->update(['image' => null]);
            }
        }

        return redirect()->route('cars.index')->with('success', 'The car has been updated.');
    }

    public function destroy(Car $car): RedirectResponse
    {
        $car->deleteImageFile();
        $car->delete(); // inquiries are removed by the foreign key cascade

        return redirect()->route('cars.index')->with('success', 'The car has been deleted.');
    }
}
