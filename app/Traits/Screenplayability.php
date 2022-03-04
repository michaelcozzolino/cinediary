<?php

namespace App\Traits;

use App\Classes\TMDBScraper;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

trait Screenplayability
{
    private Movie|Series $screenplayModel;
    private TMDBScraper $TMDBScraper;

    /**
     * Initialize the trait variables
     */
    public function init()
    {
        $this->screenplayModel = new $this->model();
        $this->TMDBScraper = new TMDBScraper();
    }

    /**
     * @param Request $request
     * @param Diary $diary
     * @return \Inertia\Response
     */
    public function index(Request $request, Diary $diary)
    {
        $findQuery = $request->input('query');
        $screenplayType = $this->screenplayModel->getTable();

        $screenplays = [
            $screenplayType => is_null($findQuery)
                ? $diary
                    ->{$screenplayType}()
                    ->orderBy('title')
                    ->paginate()
                : $diary
                    ->{$screenplayType}()
                    ->where('title', 'like', "%{$findQuery}%")
                    ->orderBy('title')
                    ->paginate(),
        ];

        return Inertia::render('Diaries/Show', compact('screenplays', 'diary'))->with(['query' => $findQuery ?? '']);
    }

    /**
     * @param Movie|Series $screenplay
     * @return \Inertia\Response
     */
    public function show(Movie|Series $screenplay)
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
     * @param Movie|Series $screenplay
     * @return int
     */
    private function getDiariesScreenplaysCount(Collection $diariesIds, Movie|Series $screenplay)
    {
        return DB::table('diary_' . $screenplay->getModelClassName())
            ->where($screenplay->getModelClassName() . '_id', $screenplay->id)
            ->whereIn('diary_id', $diariesIds)
            ->count();
    }

    /**
     * Get the number of diaries in which a specific screenplay is contained in.
     *
     * @param Movie|Series $screenplay
     * @return int
     */
    private function getContainingDiariesNumber(Movie|Series $screenplay)
    {
        return DB::table('diary_' . $screenplay->getModelClassName())
            ->where($screenplay->getModelClassName() . '_id', $screenplay->id)
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

        $screenplay = $this->screenplayModel::firstOrTranslate($this->TMDBScraper, $request->input('screenplayId'));
        if (!is_null($screenplay)) {
            $screenplay->track($diary);
            return redirect()->back();
        }

        return redirect()
            ->back()
            ->with('message', 'The requested ' . $this->screenplayModel::getModelClassName() . ' does not exist!');
    }

    /**
     * @param Diary $diary
     * @param Movie|Series $screenplay
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Diary $diary, Movie|Series $screenplay)
    {
        $screenplay->removeFromDiary($diary);
        return redirect()->back();
    }

    /*
     * Get the popular screenplays from database based on the screenplay type.
     * */
    public function indexPopular(): array
    {
        $screenplays = $this->screenplayModel
            ::where('isPopular', true)
            ->get()
            ->toArray();

        $randomBackdropPath = null;

        if ($screenplays) {
            shuffle($screenplays);
            $screenplays = array_slice($screenplays, 0, config('cinediary.homepage_max_screenplays'));

            /** getting the screenplays that do not have a blank backdrop path and taking the first one */
            $randomBackdropPathScreenplays = array_filter(
                $screenplays,
                fn($screenplay) => $screenplay['backdropPath'] !== TMDBScraper::BLANK_BACKDROP_PATH_URL,
            );

            $randomBackdropPath =
                count($randomBackdropPathScreenplays) > 0
                    ? reset($randomBackdropPathScreenplays)['backdropPath']
                    : TMDBScraper::BLANK_BACKDROP_PATH_URL;

            $screenplays = array_chunk($screenplays, config('cinediary.homepage_screenplays_per_row'));
        }

        return compact('screenplays', 'randomBackdropPath');
    }
}
