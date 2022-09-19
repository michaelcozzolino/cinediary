<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotLoggedInException;
use App\Services\UserSettingService;
use App\Traits\ExceptionContext;
use Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Redirect;

class LanguageController extends Controller
{
    public function __construct(
        protected UserSettingService $userSettingService
    ) {
    }

    public function update(string $language): RedirectResponse
    {
        if (
            in_array($language, Config::get('app.available_locales'), true) ===
            false
        ) {
            Log::info(
                sprintf(
                    'Cannot change website language because language "%s" is not available.',
                    $language
                )
            );

            return Redirect::route('home');
        }

        Session::put('locale', $language);

        try {
            $this->userSettingService->changeDefaultLanguage($language);

            Log::info(
                sprintf(
                    'Changed default language to "%s" for user %u',
                    $language,
                    $this->userSettingService->getUserService()->getLogged()->id
                )
            );
        } catch (UserNotLoggedInException $e) {
            Log::info(
                'Cannot change default language for user because it is not logged in.',
                ExceptionContext::getContext($e)
            );
        }

        Log::info(sprintf('Changed website language to "%s"', $language));

        return Redirect::back();
    }
}
