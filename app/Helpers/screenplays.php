<?php

use App\Traits\ScreenplayTypes;

if(! function_exists(' getAlreadyInDiariesScreenplaysIds')){

    /**
     * @param \Illuminate\Http\Request $request
     * @return ?array
     */
    function getAlreadyInDiariesScreenplaysIds(\Illuminate\Http\Request $request) : ?array {
        $alreadyInDiariesScreenplaysIds = [];

        if(\Auth::user()) {
            $diaries = \Auth::user()->load('diaries')->diaries;


            $screenplayTypes = (new class {
                use ScreenplayTypes;
            })->getScreenplayTypes();

            /*
             * getting the ids of all the screenplays that are in each diary
             * */
            foreach ($diaries as $diary) {
                $diaryId = $diary->id;

                foreach ($screenplayTypes as $screenplayType)
                    $alreadyInDiariesScreenplaysIds[$diaryId][$screenplayType] = $diary->{$screenplayType}->pluck('id')->toArray();
            }
        }

        return $request->routeIs([
            'search.create',
            'search.index',
            'diaries.*.index',
            'dashboard'
        ]) ? $alreadyInDiariesScreenplaysIds : null;

    }
}

if(! function_exists(' getScreenplayType')) {

    /**
     * @param \Illuminate\Http\Request $request
     * @return ?string
     */
    function getScreenplayType(\Illuminate\Http\Request $request) : ?string {

        return $request->routeIs('*.movies.*')
            ? 'movies'
            : ( $request->routeIs('*.series.*')
                ? 'series'
                : null );
    }
}
