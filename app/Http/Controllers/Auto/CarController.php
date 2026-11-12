<?php

namespace App\Http\Controllers\Auto;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarInquiryRequest;
use App\Models\Car;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Public catalog of cars for sale. */
class CarController extends Controller
{
    public const PER_PAGE = 9;

    public function index(Request $request): View
    {
        $filters = $this->filters($request);

        $cars = Car::query()
            ->filter($filters)
            ->sortBy($filters['sort'])
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('auto.pages.offer', [
            'cars' => $cars,
            'filters' => $filters,
            'brands' => Car::query()->distinct()->orderBy('brand')->pluck('brand'),
            'hasFilters' => collect($filters)->except('sort')->filter()->isNotEmpty(),
        ]);
    }

    public function show(Car $car): View
    {
        $related = Car::query()
            ->whereKeyNot($car->getKey())
            ->where('status', '!=', Car::STATUS_SOLD)
            ->orderByRaw('brand = ? desc', [$car->brand])
            ->latest('id')
            ->limit(3)
            ->get();

        return view('auto.cars.show', ['car' => $car, 'related' => $related]);
    }

    /** Store a "Request this car" inquiry. */
    public function inquire(CarInquiryRequest $request, Car $car): RedirectResponse|JsonResponse
    {
        if ($car->status === Car::STATUS_SOLD) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Sorry, this car has already been sold.',
                    'errors' => ['car' => ['Sorry, this car has already been sold.']],
                ], 422);
            }

            return redirect(route('car.show', $car).'#request')
                ->withErrors(['car' => 'Sorry, this car has already been sold.']);
        }

        $data = $request->validated();

        $car->inquiries()->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'message' => $data['message'] ?? null,
        ]);

        $message = 'Thank you! Your request has been sent. A manager will contact you shortly.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect(route('car.show', $car).'#request')->with('success', $message);
    }

    /**
     * Read the catalog filters from the query string, ignoring unknown values
     * instead of failing (the URL is user supplied and may be stale).
     */
    private function filters(Request $request): array
    {
        $maxPrice = $request->query('max_price');

        return [
            'q' => trim((string) $request->query('q', '')) ?: null,
            'brand' => trim((string) $request->query('brand', '')) ?: null,
            'fuel' => array_key_exists((string) $request->query('fuel'), Car::FUELS) ? $request->query('fuel') : null,
            'transmission' => array_key_exists((string) $request->query('transmission'), Car::TRANSMISSIONS) ? $request->query('transmission') : null,
            'max_price' => is_numeric($maxPrice) && $maxPrice > 0 ? (int) $maxPrice : null,
            'status' => $request->query('status') === 'available' ? 'available' : null,
            'sort' => array_key_exists((string) $request->query('sort'), Car::SORTS) ? $request->query('sort') : 'newest',
        ];
    }
}
