<?php

namespace App\Http\Controllers;

use App\Models\FavouriteDiary;
use App\Models\Screenplay;
use App\Models\ToWatchDiary;
use App\Models\WatchedDiary;
use App\Repositories\DiaryRepository;
use App\Services\ScreenplayContextService;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ScreenplayController extends Controller
{
    public function __construct(
        protected ScreenplayContextService $screenplayContextService,
        protected DiaryRepository $diaryRepository
    ) {
    }

    /**
     * @param  Screenplay  $screenplay
     *
     * @throws \App\Exceptions\RegistryNotFoundException
     * @return InertiaResponse
     */
    public function show(Screenplay $screenplay): InertiaResponse
    {
        $screenplayId = $screenplay->id;
        $screenplayContext = $this->screenplayContextService->getScreenplayContext();
        $screenplayType = $screenplayContext->type;
        $screenplayRepository = $screenplayContext->repository;

        $watchers = $screenplayRepository->getScreenplayCountByDiaries(
            $this->diaryRepository->getIdsByTypes([WatchedDiary::class]),
            $screenplayType,
            $screenplayId,
        );

        $lovers = $screenplayRepository->getScreenplayCountByDiaries(
            $this->diaryRepository->getIdsByTypes([FavouriteDiary::class]),
            $screenplayType,
            $screenplayId,
        );

        $futureWatchers = $screenplayRepository->getScreenplayCountByDiaries(
            $this->diaryRepository->getIdsByTypes([ToWatchDiary::class]),
            $screenplayType,
            $screenplayId,
        );

        $containingDiariesNumber = $screenplayRepository->getScreenplayCountByDiaries(
            $this->diaryRepository->getIdsByTypes([]),
            $screenplayType,
            $screenplayId,
        );

        return Inertia::render('Screenplays/Show', [
            'screenplay' => $screenplay,
            'statistics' => [
                'watchers'                => $watchers,
                'lovers'                  => $lovers,
                'futureWatchers'          => $futureWatchers,
                'containingDiariesNumber' => $containingDiariesNumber,
            ],
        ]);
    }
}
