<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    /**
     * @return Response
     */
    public function index()
    {
        $settings = \Auth::user()->settings;

        return Inertia::render('Settings/Index', compact('settings'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'adultContent' => ['boolean', 'required'],
        ]);

        \Auth::user()
            ->settings()
            ->update([
                'adultContent' => $request->input('adultContent'),
            ]);

        return Redirect::route('settings.index');
    }
}
