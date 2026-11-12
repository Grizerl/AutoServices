<?php

namespace App\Services;

use App\Models\CarInquiry;
use App\Models\Contact;
use App\Models\Repair;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

/** Data shown in the admin layout (header notifications and sidebar badges). */
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
        $carRequests = CarInquiry::where('status', CarInquiry::STATUS_NEW)->count();
        $subscriptions = Subscription::where('status', Subscription::STATUS_PENDING)->count();

        return [
            'amount' => $pending + $questions + $carRequests + $subscriptions,
            'pending' => $pending,
            'questions' => $questions,
            'car_requests' => $carRequests,
            'subscriptions' => $subscriptions,
        ];
    }
}
