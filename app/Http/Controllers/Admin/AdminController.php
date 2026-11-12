<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Members;
use App\Models\Post;
use App\Models\Repair;
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
        ]);
    }
}
