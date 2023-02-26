<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\UserSetting;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        UserSetting::whereUserId($request->user()->id)->update(['defaultLanguage' => session('locale')]);

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $currentLanguage = $request->session()->get('locale');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->put('locale', $currentLanguage);

        return redirect('/');
    }
}
