<?php

namespace App\Http\Controllers;

use App\Exceptions\Language\LanguageNotFoundException;
use App\Services\Language\Switcher as LanguageSwitcher;
use Config;
use Illuminate\Http\RedirectResponse;
use Redirect;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LanguageController extends Controller
{
    public function __construct(
        protected LanguageSwitcher $languageSwitcher
    ) {
    }

    public function update(string $language): RedirectResponse
    {
//        dd(
//            "when changing language the movies data are not updated. 21 january 2023 "
//        );
        $availableLanguages = Config::get('app.available_locales');
        try {
            $this->languageSwitcher->switchTo($language, $availableLanguages);

            return Redirect::back();
        } catch (LanguageNotFoundException $e) {
            throw new BadRequestHttpException(
                'Cannot change language because the requested does not exist.'
            );
        }
    }
}
