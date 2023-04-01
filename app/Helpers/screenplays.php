<?php

use App\Classes\TMDB\ScreenplayFetcher;
use App\Models\Screenplay;

if (!function_exists(' getAlreadyInDiariesScreenplaysIds')) {
    /**
     * Get the screenplays ids corresponding to each diary belonging to a user.
     *
     * @param \Illuminate\Http\Request $request
     * @return ?array
     */
    function getAlreadyInDiariesScreenplaysIds(
        \Illuminate\Http\Request $request
    ): ?array {
        $alreadyInDiariesScreenplaysIds = [];

        if (\Auth::user()) {
            $diaries = \Auth::user()->load('diaries')->diaries;

            $screenplayTypes = \App\Models\Screenplay::getTypes();

            /*
             * getting the ids of all the screenplays that are in each diary
             * */
            foreach ($diaries as $diary) {
                $diaryId = $diary->id;

                foreach ($screenplayTypes as $screenplayType) {
                    $alreadyInDiariesScreenplaysIds[$diaryId][
                        $screenplayType
                    ] = $diary->{$screenplayType}->pluck('id')->toArray();
                }
            }
        }

        return $request->routeIs([
            'search.index',
            'diaries.*.index',
            'dashboard',
        ])
            ? $alreadyInDiariesScreenplaysIds
            : null;
    }
}

if (!function_exists('storePopularScreenplays')) {
    function storePopularScreenplays(ScreenplayFetcher $repository)
    {
        $screenplayModels = Screenplay::getScreenplayModels();

        foreach ($screenplayModels as $screenplayModel) {
            $screenplayModel::where(['isPopular' => true])
                ->update(['isPopular' => false]);

            $screenplays = $repository->getSearcher()->getPopular();

            foreach ($screenplays as $screenplay) {
                $screenplayModel::firstOrTranslate($TMDBScraper, $screenplay->getId())
                    ->update(['isPopular' => true]);
            }
        }
    }
}

if (!function_exists(' getScreenplayType')) {
    /**
     * @param \Illuminate\Http\Request $request
     * @return ?string
     */
    function getScreenplayType(\Illuminate\Http\Request $request): ?string
    {
        return $request->routeIs('*.movies.*')
            ? 'movies'
            : ($request->routeIs('*.series.*')
                ? 'series'
                : null);
    }
}
