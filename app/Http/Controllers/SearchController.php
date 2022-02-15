<?php

namespace App\Http\Controllers;

use App\Classes\TMDBScraper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public const SEARCH_SESSION_DATA_KEY = 'searchData';

    public function create(){

        if(session()->has(self::SEARCH_SESSION_DATA_KEY))
            return redirect()->route('search.index');

        return Inertia::render('Search/Index');
    }

    public function make(Request $request){
        $request->validate(
            [
                'query' => 'required',
            ]
        );

        $TMDBScraper = new TMDBScraper();
        $query = $request->input('query');

        $screenplays = $TMDBScraper->search($query);
        session([
            self::SEARCH_SESSION_DATA_KEY => $screenplays,
            'lastQuery' => $query,

        ]);
        return redirect()->route('search.index');
    }

    public function index(){
        if(!session()->has(self::SEARCH_SESSION_DATA_KEY))
            return redirect()->route('search.create');
        $screenplays = session(self::SEARCH_SESSION_DATA_KEY);
        $lastQuery = session('lastQuery');
        $alreadyInDiariesScreenplaysIds = $this->getAlreadyInDiariesScreenplaysIds($screenplays);

        return Inertia::render('Search/Index', compact('screenplays', 'lastQuery','alreadyInDiariesScreenplaysIds'));
    }

    private function getAlreadyInDiariesScreenplaysIds(\Illuminate\Database\Eloquent\Collection $screenplays){

        $diaries = \Auth::user()->load('diaries')->diaries;

        $alreadyInDiariesScreenplaysIds = [];
        $screenplayTypes = $screenplays->keys();

        /*
         * checking if the searched screenplays are already into one or multiple customer's diaries
         * by intersecting them
         * */
        foreach ($diaries as $diary){
            $diaryId = $diary->id;

            foreach ($screenplayTypes as $screenplayType)
                $alreadyInDiariesScreenplaysIds[$diaryId][$screenplayType] = array_intersect(
                    $diary->{$screenplayType}->pluck('id')->toArray(),
                    $screenplays[$screenplayType]->pluck('id')->toArray(),
                );
        }
        return $alreadyInDiariesScreenplaysIds;

    }

}
