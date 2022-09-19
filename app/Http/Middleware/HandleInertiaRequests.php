<?php

namespace App\Http\Middleware;

use App\Models\Diary;
use App\Models\User;
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
        $alreadyInDiariesScreenplaysIds = getAlreadyInDiariesScreenplaysIds($request);

        return array_merge(parent::share($request), compact('alreadyInDiariesScreenplaysIds'), [
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user()
                        ? [
                            'user' => $request->user(),
                            'name' => $request->user()->name,
                            'diaries' => $request->user()->diaries() /*Diary::setEagerLoads([])
                                ->whereUserId($request->user()->id)*/
                                ->get(['id', 'name', 'type']),
                        ]
                        : null,
                ];
            },
            'screenplayType' => getScreenplayType($request),
            'config' => [
                'github_url' => config('cinediary.github_url'),
                'app_name' => config('app.name'),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'current_language' => function () {
                return app()->getLocale();
            },
            'availableLocales' => config('app.available_locales'),
            'translations' => function () {
                return $this->translations();
            },
        ]);
    }

    /**
     * Get the translations array.
     *
     * @return array|mixed
     */
    public function translations()
    {
        $translations = [];
        $currentLanguage = app()->getLocale();
        $languageFile = lang_path($currentLanguage . '.json');

        if (file_exists($languageFile)) {
            $translations = array_merge($translations, (array) json_decode(file_get_contents($languageFile), true));
        }

        $languageDirectory = lang_path($currentLanguage);
        if (file_exists($languageDirectory)) {
            $files = array_diff(scandir($languageDirectory), ['.', '..']);

            foreach ($files as $file) {
                $filePath = $languageDirectory . '/' . $file;

                $filePathInfo = pathinfo($filePath);

                if (array_key_exists('extension', $filePathInfo) && $filePathInfo['extension'] === 'json') {
                    $translations = array_merge($translations, (array) json_decode(file_get_contents($filePath), true));
                }
            }
        }
        //        dd($translations);
        return $translations;
    }
}
