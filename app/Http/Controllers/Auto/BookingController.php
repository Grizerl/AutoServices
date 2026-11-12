<?php

namespace App\Http\Controllers\Auto;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Repair;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    /** Store a repair request sent from the public "Get in touch" form. */
    public function store(BookingRequest $request): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        Repair::create([
            'name' => $data['name'],
            'telephone' => $data['phone'],
            'car' => $data['car'],
            'comment' => $data['comment'],
        ]);

        $message = 'Thank you! Your request has been sent. We will call you back shortly.';

        // AJAX submit (no page reload)
        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect(route('home_auto').'#contacts')->with('success', $message);
    }
}
