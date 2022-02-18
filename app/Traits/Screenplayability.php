<?php

namespace App\Traits;

use App\Classes\TMDBScraper;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function PHPUnit\Framework\returnValue;

trait Screenplayability {

    private Movie|Series $screenplayModel;
    private $user;
    private TMDBScraper $TMDBScraper;

    public function init(){
        $this->screenplayModel = new $this->model;
        $this->TMDBScraper = new TMDBScraper();
    }

    public function index(Diary $diary): \Inertia\Response {

        $screenplayType = $this->screenplayModel->getTable();

        $screenplays = [
            $screenplayType => $diary->{$screenplayType}()->orderBy('title')
                ->paginate(config('cinediary.pagination_limit')),

        ];
        return Inertia::render('Diaries/Show', compact('screenplays','diary') );
    }

    public function show($screenplay) : \Illuminate\Contracts\View\View {

        return view('pages.screenplays.show');

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
            'The requested ' . $this->screenplayModel::getTableName() . ' does not exist!' );

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
