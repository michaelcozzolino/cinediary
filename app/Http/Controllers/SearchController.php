<?php

namespace App\Http\Controllers;

use App\Classes\TMDBScraper;
use App\Traits\Screenplayability;
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

        return Inertia::render('Search/Index', compact('screenplays', 'lastQuery'));
    }

}
