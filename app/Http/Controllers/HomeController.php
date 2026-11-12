<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Landing page after login: admins go straight to the admin panel. */
    public function index(Request $request): View|RedirectResponse
    {
        if ($request->user()->hasRole('Admin')) {
            return redirect()->route('admin-home');
        }

        return view('home');
    }
}
