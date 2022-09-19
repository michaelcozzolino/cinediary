<?php

namespace App\Http\Controllers;

use App\Classes\TMDB\ScreenplayFetcher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public const SEARCH_SESSION_DATA_KEY = 'searchData';

    /**
     * @param array<ScreenplayFetcher>  $TMDBScreenplayRepositories
     */
    public function __construct(protected array $TMDBScreenplayRepositories)
    {
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function create()
    {
        if (session()->has(self::SEARCH_SESSION_DATA_KEY)) {
            return redirect()->route('search.index');
        }

        return Inertia::render('Search/Index');
    }

    /**
     * Make a search.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function make(Request $request)
    {
        $request->validate([
            'query' => 'required',
        ]);

        $query = $request->input('query');

        $screenplays = [];
        foreach ($this->TMDBScreenplayRepositories as $repository){
            $screenplays[$repository->getScreenplay()->getTable()] = $repository->findByQuery($query);
        }

        session([
            self::SEARCH_SESSION_DATA_KEY => $screenplays,
            'lastQuery' => $query,
        ]);

        return redirect()->route('search.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function index()
    {
        if (!session()->has(self::SEARCH_SESSION_DATA_KEY)) {
            return redirect()->route('search.create');
        }
        $screenplays = session(self::SEARCH_SESSION_DATA_KEY);
        $lastQuery = session('lastQuery');

        return Inertia::render('Search/Index', compact('screenplays', 'lastQuery'));
    }
}
