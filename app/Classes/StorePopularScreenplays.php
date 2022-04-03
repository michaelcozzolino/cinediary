<?php

namespace App\Classes;

use App\Traits\ScreenplayTypes;

class StorePopularScreenplays
{
    use ScreenplayTypes;

    public function __invoke()
    {
        $this->storePopularScreenplays();
    }

    /**
     * Store popular screenplays into the database.
     */
    private function storePopularScreenplays()
    {
        $TMDBScraper = new TMDBScraper();
        $screenplayModels = $this->getScreenplayModels();

        foreach ($screenplayModels as $screenplayModel) {
            $screenplayModel::where(['isPopular' => true])->update(['isPopular' => false]);
            $screenplays = $TMDBScraper->getPopular($screenplayModel);

            foreach ($screenplays as $screenplay) {
                $screenplayModel::firstOrTranslate($TMDBScraper, $screenplay->getId())->update(['isPopular' => true]);
            }
        }
    }
}
