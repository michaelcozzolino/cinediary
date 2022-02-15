<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use App\Traits\ScreenplayTypes;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class DashboardController extends Controller
{
    use ScreenplayTypes;
    private const LETTERS = [
        '#','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q',
        'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    ];

    public function index(): \Inertia\Response{

        $chartData = [];
        $currentLanguage = app()->getLocale();
        $lastWatchedScreenplaysData = [];
        $screenplayTypes = $this->getScreenplayTypes();
        $watchedDiary = Diary::getWatched();

        foreach ($screenplayTypes as $screenplayType) {

            $lastWatchedScreenplaysData[$screenplayType] = $watchedDiary->getLastAddedScreenplays($screenplayType, 4);

            $chartData['watchedScreenplaysPercentageChart'][$screenplayType] = $watchedDiary->{$screenplayType}()->count();

            /*
             * taking the first letter of each screenplay, grouping and counting them
             * */
            $lettersBarChartData = $watchedDiary->{$screenplayType}()
                ->selectRaw("substr(json_extract(title,'$.{$currentLanguage}'),2,1) as letter, count(*) as number")
                ->groupBy('letter')->orderBy("number", "desc")->get();

            $chartData['lettersBarChart'][$screenplayType] = $this->getLettersCount();

            foreach ($lettersBarChartData as $lettersBarChartDatum){
                $letter = strtoupper($lettersBarChartDatum->letter);
                $chartData['lettersBarChart'][$screenplayType][$letter] = $lettersBarChartDatum->number;
            }

        }

        $chartData['watchedGenresPercentageChart'] = $this->getGenresCount($watchedDiary);

        return Inertia::render(
            'Home/Dashboard/Index',
            compact('chartData', 'lastWatchedScreenplaysData')
        );

    }

    /*
     * it associates each letter to a initial 0 value representing the number of screenplays whose name
     * begins with that letter
     * */
    private function getLettersCount() : array{
        return array_combine(self::LETTERS, array_fill(0,count(self::LETTERS),0));
    }

    private function getGenresCount(Diary $diary) : array {
        $data = [];

        foreach ($screenplayTypes = $this->getScreenplayTypes() as $screenplayType) {
            /*
             *  grouping by genre and counting the screenplays having that genre
             * */
            $genresCountResult = $diary->{$screenplayType}()
                ->select(['genre', DB::raw('count(*) as watchedScreenplaysNumber')])
                ->groupBy('genre')->get();

            $data[$screenplayType] = array_combine(
                $genresCountResult->pluck(['genre'])->toArray(),
                $genresCountResult->pluck('watchedScreenplaysNumber')->toArray(),
            );


        }

        /*
         * merging the keys (genres) by removing duplicates
         * of each screenplay type because they might have different genres
         * */
        $genres = array_unique(
            array_merge(
                array_keys($data[$screenplayTypes[0]]),
                array_keys($data[$screenplayTypes[1]])
            )
        );

        /*
         * creating an array to sum the screenplays number for a given genre
         * */
        $genresCount = array_fill_keys($genres, 0);

        foreach ($genres as $genre){

            foreach ($screenplayTypes as $screenplayType){
                if(array_key_exists($genre, $data[$screenplayType]))
                    $genresCount[$genre] += $data[$screenplayType][$genre];
            }
        }

        /*
         * final array example
         *
         *  [
         *   'action' => 1,
         *   'comedy' => 10
         *  ]
         *
         * */
        return $genresCount;

    }


}
