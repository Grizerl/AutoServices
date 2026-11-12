<?php

namespace App\Http\Controllers\Auto;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('auto.contact.contacts');
    }

    /** Store a question sent from the public contact form. */
    public function store(ContactRequest $request): RedirectResponse|JsonResponse
    {
        $data = $request->validated();

        Contact::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'message' => $data['message'],
        ]);

        $message = 'Thank you! Your question has been sent. A manager will contact you soon.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect(route('contacts').'#ask-question')->with('success', $message);
    }
}
