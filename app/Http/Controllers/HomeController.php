<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Route;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index(): InertiaResponse|RedirectResponse
    {
        if (Auth::check()) {
            return Redirect::route('dashboard');
        }

        return Inertia::render('Home/Index', [
            'canLogin'       => Route::has('login'),
            'canRegister'    => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion'     => PHP_VERSION,
            'canVerifyEmail' => false,
            'status'         => session('status'),
        ]);
    }
}
