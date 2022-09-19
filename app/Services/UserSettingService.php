<?php

declare(strict_types=1);

namespace App\Services;

class UserSettingService
{
    public function __construct(protected readonly UserService $userService)
    {
    }

    /**
     * @param  string  $language
     *
     * @throws \App\Exceptions\UserNotLoggedInException
     * @return void
     */
    public function changeDefaultLanguage(string $language): void
    {
        $this->userService->getLogged()->settings()->update(['defaultLanguage' => $language]);
    }

    public function getUserService(): UserService
    {
        return $this->userService;
    }
}
