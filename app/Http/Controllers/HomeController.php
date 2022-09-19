<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotLoggedInException;
use App\Services\UserService;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Route;

class HomeController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index()
    {
        try {
            $this->userService->getLogged();

            return redirect()->route('dashboard');
        } catch (UserNotLoggedInException $e) {
            return Inertia::render('Home/Index', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'laravelVersion' => Application::VERSION,
                'phpVersion' => PHP_VERSION,
                'canVerifyEmail' => false,
                'status' => session('status'),
            ]);
        }
    }
}
