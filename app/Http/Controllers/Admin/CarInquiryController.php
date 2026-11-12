<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarInquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** Admin: requests sent from the "Request this car" form. */
class CarInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = array_key_exists((string) $request->query('status'), CarInquiry::STATUSES) ? $request->query('status') : null;

        return view('admin.car-inquiries.index', [
            'inquiries' => CarInquiry::query()
                ->with('car')
                ->when($status, fn ($q, $s) => $q->where('status', $s))
                ->latest('id')
                ->paginate(15)
                ->withQueryString(),
            'status' => $status,
        ]);
    }

    public function update(Request $request, CarInquiry $carInquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(CarInquiry::STATUSES))],
        ]);

        $carInquiry->update($data);

        return back()->with('success', 'The request has been marked as '.strtolower($carInquiry->status_label).'.');
    }

    public function destroy(CarInquiry $carInquiry): RedirectResponse
    {
        $carInquiry->delete();

        return back()->with('success', 'The request has been deleted.');
    }
}
