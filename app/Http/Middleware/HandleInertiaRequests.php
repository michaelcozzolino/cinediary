<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = $request->user();

        $alreadyInDiariesScreenplaysIds = getAlreadyInDiariesScreenplaysIds($request);
        return array_merge(parent::share($request), compact('alreadyInDiariesScreenplaysIds'), [
            'auth' => [
                'userData' => [
                    'user' => $user,
                    'diaries' => $user->diaries ?? null,
                ],
            ],
            'screenplayType' => getScreenplayType($request),

            'config' => [
                'github_url' => config('cinediary.github_url'),
                'app_name' => config('app.name'),
            ],

            'flash' => [
                'message' => fn() => $request->session()->get('message'),
            ],
            'locale' => function () {
                return app()->getLocale();
            },
            'availableLocales' => config('app.available_locales'),
            'language' => function () {
                return $this->translations(lang_path(app()->getLocale() . '.json'));
            },
        ]);
    }

    /**
     * Get the translations array.
     *
     * @param $json
     * @return array|mixed
     */
    private function translations($json)
    {
        if (!file_exists($json)) {
            return [];
        }
        return json_decode(file_get_contents($json), true);
    }
}
