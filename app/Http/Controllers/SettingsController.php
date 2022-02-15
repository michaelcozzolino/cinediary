<?php

namespace App\Http\Controllers;

use App\Classes\TMDBScraper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{

    public function index(): Response {
        $settings = \Auth::user()->settings;
        return Inertia::render('Settings/Index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse {
       $request->validate([
            'TMDBApiKey' =>[
                function($attribute, $value, $fail){
                    $isApiKeyValid = is_null($value) ? true : (new TMDBScraper($value))->isApiKeyValid();
                    if(!$isApiKeyValid)
                        $fail("The " . $attribute . " is not valid");
                }
            ],
            'adultContent' => ['boolean','required'],
        ]);

        \Auth::user()->settings()->update([
            'TMDBApiKey' => $request->input('TMDBApiKey'),
            'adultContent' => $request->input('adultContent'),
        ]);

        return Redirect::route('settings.index');

    }
}
