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

trait Screenplayability {

    private Movie|Series $screenplayModel;
    private $user;
    private TMDBScraper $TMDBScraper;

    public function init(){
        $this->screenplayModel = new $this->model;
        $this->TMDBScraper = new TMDBScraper();
    }

    public function index(Request $request, Diary $diary): \Inertia\Response {
        $findQuery = $request->input('query');
        $screenplayType = $this->screenplayModel->getTable();

        $screenplays = [
            $screenplayType => is_null($findQuery) ?

                $diary->{$screenplayType}()
                    ->orderBy('title')
                    ->paginate(config('cinediary.pagination_limit')) :

                $diary->{$screenplayType}()
                    ->where('title', 'like', "%{$findQuery}%")
                    ->orderBy('title')
                    ->paginate(config('cinediary.pagination_limit'))
        ];

        return Inertia::render('Diaries/Show', compact('screenplays','diary'))
            ->with(['query' => $findQuery ?? '']);
    }

    public function show(Movie|Series $screenplay) : \Inertia\Response {
        $watchers = $this->getDiariesScreenplaysCount(
            Diary::withoutGlobalScope('userDiaries')->watched()->get()->pluck('id'),
            $screenplay
        );

        $lovers = $this->getDiariesScreenplaysCount(
            Diary::withoutGlobalScope('userDiaries')->favourite()->get()->pluck('id'),
            $screenplay
        );

        $futureWatchers = $this->getDiariesScreenplaysCount(
            Diary::withoutGlobalScope('userDiaries')->toWatch()->get()->pluck('id'),
            $screenplay
        );

        $containingDiariesNumber = $this->getContainingDiariesNumber($screenplay);
        $statistics = compact('watchers', 'lovers', 'futureWatchers', 'containingDiariesNumber');

        return Inertia::render('Screenplays/Show',
            compact('screenplay', 'statistics' ));
    }


    /**
     * Get the total number of a specific screenplay belonging to the given diaries.
     * @param \Illuminate\Support\Collection $diariesIds
     * @param Movie|Series $screenplay
     * @return int
     */
    private function getDiariesScreenplaysCount(Collection $diariesIds, Movie|Series $screenplay) : int {
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
    private function getContainingDiariesNumber(Movie|Series $screenplay) : int {
        return DB::table('diary_' . $screenplay->getModelClassName())
            ->where($screenplay->getModelClassName() . "_id", $screenplay->id)->count();
    }


    public function store(Request $request, Diary $diary){

        $request->validate([
                'screenplayId' => [
                    'required',
                    'integer',
                    'min:0',
                ],
            ]
        );

        $screenplay = $this->screenplayModel::firstOrTranslate($this->TMDBScraper, $request->input('screenplayId'));
        if(!is_null($screenplay)) {
            $screenplay->addToDiary($diary);
            return redirect()->back();
        }

        return redirect()->back()->with('message',
            'The requested ' . $this->screenplayModel::getModelClassName() . ' does not exist!' );

    }


    public function destroy(Diary $diary, Movie|Series $screenplay){

        $screenplay->removeFromDiary($diary);
        return redirect()->back()->with(['message' => 'deleted']);

    }

    /*
     * It returns the popular screenplays based on the screenplay type
     * */
    public function indexPopular(): array {
        $screenplays = $this->screenplayModel::where('isPopular', true)->get()->toArray();
        $randomBackdropPath = null;
        if($screenplays) {
            shuffle($screenplays);
            $screenplays = array_slice($screenplays, 0, config('cinediary.homepage_max_screenplays'));
            $randomBackdropPath = $screenplays[rand(0, count($screenplays) - 1)]['backdropPath'];
            $screenplays = array_chunk($screenplays, config('cinediary.homepage_screenplays_per_row'));
        }
        return compact('screenplays', 'randomBackdropPath');
    }
}
