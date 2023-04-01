<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeSearchRequest;
use App\Services\SearchServiceInterface;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function __construct(protected SearchServiceInterface $searchService)
    {
    }

    /**
     * Make a search.
     *
     * @param  MakeSearchRequest  $request
     *
     * @throws \App\Exceptions\InvalidModelClassNameException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function make(MakeSearchRequest $request)
    {
        $this->searchService->search($request->input('query'));

        return redirect()->route('search.index');
    }

    public function index(): Response
    {
        $lastQuery = $this->searchService->getLastSearchQuery();
        $screenplays = $this->searchService->getLastSearchResult();

        return Inertia::render(
            'Search/Index',
            compact('screenplays', 'lastQuery')
        );
    }
}
