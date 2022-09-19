<?php

namespace App\Http\Controllers;

use App\Classes\TMDB\Parser;
use App\Models\Diary;
use App\Models\Screenplay;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

trait ScreenplayController
{
    /**
     * @param Request $request
     * @param Diary $diary
     * @return \Inertia\Response
     */
    public function index(Request $request, Diary $diary)
    {
        $findQuery = $request->input('query');

        $screenplayType = $this->TMDBScreenplayRepository->getScreenplay()->getTable();

        $screenplaysQuery = $diary->{$screenplayType}()->orderBy('title');

        $screenplays = [
            $screenplayType => is_null($findQuery)
                ? $screenplaysQuery->paginate()
                : $screenplaysQuery->where('title', 'like', "%$findQuery%")->paginate(),
        ];

        return Inertia::render('Diaries/Show', compact('screenplays', 'diary'))->with(['query' => $findQuery ?? '']);
    }

    /**
     * @param $screenplay
     * @return \Inertia\Response
     */
    public function show($screenplay): Response
    {
        $watchers = $this->getDiariesScreenplaysCount(
            Diary::withoutGlobalScope('userDiaries')
                ->watched()
                ->get()
                ->pluck('id'),
            $screenplay,
        );

        $lovers = $this->getDiariesScreenplaysCount(
            Diary::withoutGlobalScope('userDiaries')
                ->favourite()
                ->get()
                ->pluck('id'),
            $screenplay,
        );

        $futureWatchers = $this->getDiariesScreenplaysCount(
            Diary::withoutGlobalScope('userDiaries')
                ->toBeWatched()
                ->get()
                ->pluck('id'),
            $screenplay,
        );

        $containingDiariesNumber = $this->getContainingDiariesNumber($screenplay);
        $statistics = compact('watchers', 'lovers', 'futureWatchers', 'containingDiariesNumber');

        return Inertia::render('Screenplays/Show', compact('screenplay', 'statistics'));
    }

    /**
     * Get the total number of a specific screenplay belonging to the given diaries.
     *
     * @param \Illuminate\Support\Collection $diariesIds
     * @param $screenplay
     * @return int
     */
    private function getDiariesScreenplaysCount(Collection $diariesIds, $screenplay)
    {
        $className = getClassName($this->TMDBScreenplayRepository->getScreenplay()::class);

        return DB::table(sprintf('diary_%s', $className))
            ->where(sprintf('%s_id', $className), $screenplay->id)
            ->whereIn('diary_id', $diariesIds)
            ->count();
    }

    /**
     * Get the number of diaries in which a specific screenplay is contained in.
     *
     * @param $screenplay
     * @return int
     */
    private function getContainingDiariesNumber($screenplay)
    {
        $className = getClassName($this->TMDBScreenplayRepository->getScreenplay()::class);

        return DB::table(sprintf('diary_%s', $className))
            ->where(sprintf('%s_id', $className), $screenplay->id)
            ->count();
    }

    /**
     * @param Request $request
     * @param Diary $diary
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Diary $diary)
    {
        $request->validate([
            'screenplayId' => ['required', 'integer', 'min:0'],
        ]);

        $screenplayId = $request->input('screenplayId');

        $screenplay = $this->translator->firstOrTranslate($screenplayId, config('app.available_locales'));
//        dd($screenplay->getTable());
        if ($screenplay !== null) {
            $screenplay->save();

            $diary->addScreenplay($screenplay);

            return redirect()->back();
        }

        return redirect()
            ->back()
            ->with(
                'message',
                sprintf(
                    'The requested %s does not exist!',
                    getClassName($this->TMDBScreenplayRepository->getScreenplay()::class)
                )
            );
    }

    /**
     * @param  Diary  $diary
     * @param  Screenplay       $screenplay
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Diary $diary, Screenplay $screenplay)
    {
        $diary->unWatch($screenplay);

        return redirect()->back();
    }

    /*
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
                fn ($screenplay) => $screenplay['backdropPath'] !== Parser::BLANK_BACKDROP_PATH_URL,
            );

            $randomBackdropPath =
                count($randomBackdropPathScreenplays) > 0
                    ? reset($randomBackdropPathScreenplays)['backdropPath']
                    : Parser::BLANK_BACKDROP_PATH_URL;

            $screenplays = array_chunk($screenplays, config('cinediary.homepage_screenplays_per_row'));
        }

        return compact('screenplays', 'randomBackdropPath');
    }
}
