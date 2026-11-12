<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Repair;
use Illuminate\Support\Facades\Auth;

/** Data shown in the admin layout (header notifications and sidebar). */
class AdminPanel
{
    public function index(): array
    {
        return [
            'users' => Auth::user()?->name,
        ];
    }

    public function show(): array
    {
        $pending = Repair::where('done', Repair::STATUS_PENDING)->count();
        $questions = Contact::count();

        return [
            'amount' => $pending + $questions,
            'pending' => $pending,
            'questions' => $questions,
        ];
    }
}
