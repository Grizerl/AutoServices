<?php

namespace App\Http\Controllers\Auto;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Members;
use App\Models\Post;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('auto.index', [
            'post' => Post::oldest()->get(),
            'client' => Client::latest()->get(),
            'members' => Members::oldest()->get(),
        ]);
    }
}
