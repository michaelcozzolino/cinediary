<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettings\Update\Request as UpdateUserSettingsRequest;
use App\Repositories\UserSettingRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use LogicException;

class UserSettingsController extends Controller
{
    public function __construct(protected UserSettingRepository $userSettingRepository)
    {

    }

    public function index(): InertiaResponse
    {
        $userId = auth()->id();
        $settings = $this->userSettingRepository->findFirstByCriteria(['user_id' => $userId]);

        if ($settings === null) {
            throw new LogicException(
                sprintf('Settings for user `%d` do not exist.', $userId)
            );
        }

        return Inertia::render('Settings/Index', compact('settings'));
    }

    public function update(UpdateUserSettingsRequest $request): RedirectResponse
    {
        $userId = auth()->id();

        $updatePerformed = $this->userSettingRepository->updateByUser($userId, $request->toArray());

        if ($updatePerformed === false) {
            throw new LogicException(sprintf('Settings for user `%u` not updated.', $userId));
        }

        return Redirect::route('settings.index');
    }
}
