<?php

declare(strict_types=1);

namespace App\Services\Language;

use App\Exceptions\Language\LanguageNotFoundException;
use App\Repositories\UserSettingRepository;
use Auth;
use Illuminate\Support\Facades\Log;

class Switcher
{
    public function __construct(protected UserSettingRepository $settingRepository)
    {

    }

    /**
     * @param  string  $language
     * @param  array   $availableLanguages
     *
     * @throws LanguageNotFoundException
     * @return void
     */
    public function switchTo(string $language, array $availableLanguages): void
    {
        $this->guardAgainstUnavailableLanguage($language, $availableLanguages);

        $this->setWebsiteLanguage($language);

        $this->setUserLanguage($language);

        Log::info(sprintf('Changed website language to "%s"', $language));
    }

    /**
     * @param  string         $language
     * @param  array<string>  $availableLanguages
     *
     * @throws LanguageNotFoundException
     * @return void
     */
    protected function guardAgainstUnavailableLanguage(string $language, array $availableLanguages): void
    {
        if (in_array($language, $availableLanguages, true) === false) {
            throw new LanguageNotFoundException(
                sprintf(
                    'Language %s does not exist. Available ones are %s',
                    $language,
                    implode(', ', $availableLanguages)
                )
            );
        }
    }

    protected function setWebsiteLanguage(string $language): void
    {
        session()->put('locale', $language);

        app()->setLocale($language);
    }

    protected function setUserLanguage(string $language): void
    {
        $userId = Auth::id();

        if ($userId !== null) {
            $this->settingRepository->changeDefaultLanguageByUser($userId, $language);
        }
    }
}
