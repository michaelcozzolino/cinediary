<?php

namespace App\Http\Middleware;

use App\Models\UserSetting;
use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next)
    {
        $availableLanguages = config('app.available_locales');

        if ($request->wantsJson() && str_starts_with($request->path(), 'api')) {
            $contentLanguage = $request->header('Content-Language');

            app()->setLocale(config('app.locale'));

            if (in_array($contentLanguage, $availableLanguages)) {
                app()->setLocale($contentLanguage);
            }
        } else {
            $locale = null;

            if (!session()->has('locale')) {
                if (\Auth::check() && \Auth::user()->hasVerifiedEmail()) {
                    $locale = UserSetting::whereUserId(\Auth::user()->id)->first()->defaultLanguage;
                } else {
                    $locale = $this->getCountryIp(\Request::ip(), new Client());
                }

                if (!in_array($locale, $availableLanguages)) {
                    $locale = config('app.locale');
                }

                app()->setLocale($locale);

                session(compact('locale'));
            }

            app()->setLocale(session()->get('locale'));
        }

        return $next($request);
    }

    /**
     * Get the country of a given ip if available.
     *
     * @param string $ip
     * @param Client $client
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCountryIp(string $ip, Client $client)
    {
        $country = null;
        try {
            $response = json_decode($client->get("https://ipinfo.io/{$ip}/geo")->getBody());

            return strtolower($response->country);
        } catch (\Exception $e) {
            return null;
        }
    }
}
