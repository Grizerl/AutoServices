<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/** Admin: questions submitted through the public contact form. */
class ContactController extends Controller
{
    public function index(): View
    {
        return view('admin.question.index', [
            'contact' => Contact::latest()->paginate(15),
        ]);
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contact.index')->with('success', 'The question has been deleted.');
    }
}
