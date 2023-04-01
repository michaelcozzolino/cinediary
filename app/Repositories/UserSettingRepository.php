<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserSetting;

class UserSettingRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(UserSetting::class);
    }

    public function changeDefaultLanguageByUser(int $userId, string $language): void
    {
        $this->updateByUser($userId, [
            'defaultLanguage' => $language,
        ]);
    }

    public function updateByUser(int $userId, array $updates): bool
    {
        return (bool) $this->model::where('user_id', $userId)->update($updates);
    }
}
