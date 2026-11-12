<?php

namespace App\Http\Controllers\Auto;

use App\Http\Controllers\Controller;
use App\Models\Car;
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
            // featured cars first, topped up with the newest available ones
            'featuredCars' => Car::query()
                ->with('media')
                ->where('status', Car::STATUS_AVAILABLE)
                ->orderByDesc('is_featured')
                ->orderByDesc('id')
                ->limit(3)
                ->get(),
        ]);
    }
}
