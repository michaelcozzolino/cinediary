<?php

namespace App\Http\Controllers;

use App\Classes\TMDB\ScreenplayParser;
use App\Exceptions\Diary\MissingScreenplayFromDiaryException;
use App\Exceptions\ScreenplayNotTranslatableException;
use App\Http\Requests\AddScreenplayRequest;
use App\Models\Diary;
use App\Models\Screenplay;
use App\Repositories\DiaryRepository;
use App\Services\ScreenplayContextService;
use App\Services\ScreenplayService;
use App\Traits\ExceptionContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Redirect;

class DiaryScreenplayController extends Controller
{
    public function __construct(
        protected ScreenplayService $screenplayService,
        protected ScreenplayContextService $screenplayContextService,
        protected DiaryRepository $diaryRepository,
    ) {
    }

    /**
     * @param  Request  $request
     * @param  Diary    $diary
     *
     * @return InertiaResponse
     */
    public function index(Request $request, Diary $diary): InertiaResponse
    {
        //dd("screenplays are not refreshed when redirecting back after changin language, probably due to non reactive prop")
        $title = $request->input('query') ?? '';

        $screenplayContext = $this->screenplayContextService->getScreenplayContext();

        $screenplays = [
            $screenplayContext->table => $screenplayContext->repository
                ->findPaginatedByDiary(
                    $screenplayContext->getDiaryRelation($diary),
                    $title,
                ),
        ];

        return Inertia::render(
            'Diaries/Show',
            compact('screenplays', 'diary')
        )->with(['query' => $title]);
    }

    /**
     * @param  AddScreenplayRequest  $request
     * @param  Diary                 $diary
     *
     * @return RedirectResponse
     */
    public function add(AddScreenplayRequest $request, Diary $diary): RedirectResponse
    {
        $screenplayId = $request->input('screenplayId');

        try {
            $screenplayClass = $this->screenplayContextService->getScreenplayContext()->class;
            $screenplay = $this->screenplayService->store($screenplayClass, $screenplayId);

            $screenplayAddedToDiary = $diary->addScreenplay($screenplayId) !== [];

            $message = $screenplayAddedToDiary
                ? sprintf('Screenplay "%s" added to diary "%s"', $screenplay->title, $diary->name)
                : sprintf(
                    'Screenplay "%s" not added to diary "%s" because it already exists in it',
                    $screenplay->title,
                    $diary->name
                );

            return \Illuminate\Support\Facades\Redirect::back()->with('message', $message);
        } catch (ScreenplayNotTranslatableException $e) {
            Log::warning(
                sprintf('Screenplay with id #%u does not exist in TMDB and so, it is not translatable', $screenplayId)
            );

            return Redirect::back()->with(
                'message',
                sprintf(
                    '%s with id #%u does not exist!',
                    $this->screenplayService->getWatchableTable(),
                    $screenplayId
                )
            );
        }
    }

    /**
     * @param  Diary       $diary
     * @param  Screenplay  $screenplay
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Diary $diary, Screenplay $screenplay)
    {
        try {
            $diary->removeScreenplay($screenplay->id);

            $message = __('flash.screenplay_removed', ['screenplay_title' => $screenplay->title]);
        } catch (MissingScreenplayFromDiaryException $e) {
            $message = sprintf(
                'Screenplay #%u cannot be removed from diary #%u because it does not exist.',
                $screenplay->id,
                $diary->id
            );

            Log::info(
                $message,
                ExceptionContext::getContext($e)
            );
        }

        return Redirect::back()->with(compact('message'));
    }

    /* todo: refactor
     * Get the popular screenplays from database based on the screenplay type.
     * */
    public function indexPopular(): array
    {
        $screenplays = $this->TMDBScreenplayRepository->getScreenplay()::class::where('isPopular', true)
                                                                              ->get()
                                                                              ->toArray();

        $randomBackdropPath = null;

        if ($screenplays) {
            shuffle($screenplays);
            $screenplays = array_slice($screenplays, 0, config('cinediary.homepage_max_screenplays'));

            /** getting the screenplays that do not have a blank backdrop path and taking the first one */
            $randomBackdropPathScreenplays = array_filter(
                $screenplays,
                fn ($screenplay) => $screenplay['backdropPath'] !== ScreenplayParser::BLANK_BACKDROP_PATH_URL,
            );

            $randomBackdropPath =
                count($randomBackdropPathScreenplays) > 0
                    ? reset($randomBackdropPathScreenplays)['backdropPath']
                    : ScreenplayParser::BLANK_BACKDROP_PATH_URL;

            $screenplays = array_chunk($screenplays, config('cinediary.homepage_screenplays_per_row'));
        }

        return compact('screenplays', 'randomBackdropPath');
    }
}
