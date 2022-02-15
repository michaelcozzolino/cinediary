<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SetLocale{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        $locale = null;
        if (!session()->has('locale')) {
            if (\Auth::check())
                $locale = Setting::whereUserId(\Auth::user()->id)->first()->defaultLanguage;
            else
                $locale = $this->getCountryIp(\Request::ip(), new Client());

            if(!in_array($locale, config('app.available_locales')))
                $locale = config('app.locale');

            app()->setLocale($locale);
            session(compact('locale'));

        }

        app()->setLocale(session()->get('locale'));

        return $next($request);

    }

    public function getCountryIp($ip,  Client $client){
        $country = null;
        try {
            $response = json_decode($client->get("https://ipinfo.io/{$ip}/geo")->getBody());
            return strtolower($response->country);

        } catch (\Exception $e) {
            return null;
        }
    }

}
