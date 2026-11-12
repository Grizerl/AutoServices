<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarInquiry;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Members;
use App\Models\Post;
use App\Models\Repair;
use App\Models\Subscription;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.index', [
            'post' => Post::count(),
            'client' => Client::count(),
            'members' => Members::count(),
            'repair' => Repair::count(),
            'contact' => Contact::count(),
            'pending' => Repair::where('done', Repair::STATUS_PENDING)->count(),
            'cars' => Car::where('status', Car::STATUS_AVAILABLE)->count(),
            'carRequests' => CarInquiry::where('status', CarInquiry::STATUS_NEW)->count(),
            'pendingSubscriptions' => Subscription::where('status', Subscription::STATUS_PENDING)->count(),
            'activeSubscriptions' => Subscription::where('status', Subscription::STATUS_ACTIVE)->count(),
        ]);
    }
}
