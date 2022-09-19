<?php

namespace App\Classes;

use App\Classes\TMDB\ScreenplayFetcher;
use App\Classes\TMDB\Translator;
use App\Models\Screenplay;
use Illuminate\Support\Collection;

class StorePopularScreenplays
{
    /**
     * @param  array<ScreenplayFetcher>  $TMDBScreenplayRepositories
     * @param  Translator                $translator
     */
    public function __construct(protected array $TMDBScreenplayRepositories)
    {
    }

    public function __invoke()
    {
        $this->storePopularScreenplays();
    }

    /**
     * Store popular screenplays into the database.
     */
    private function storePopularScreenplays()
    {
        foreach (
            $this->TMDBScreenplayRepositories
            as $TMDBScreenplayRepository
        ) {
            $screenplayInstance = $TMDBScreenplayRepository->getScreenplay();
            $screenplayInstance::where(['isPopular' => true])
                ->update(['isPopular' => false]);
            /** @var Collection<Screenplay> $popularScreenplays */
            $popularScreenplays = $TMDBScreenplayRepository
                ->getSearcher()
                ->getPopular();

            $translator = new Translator($TMDBScreenplayRepository);

            foreach ($popularScreenplays as $popularScreenplay) {
                $translatedPopularScreenplay = $translator->firstOrTranslate(
                    $popularScreenplay->getId()
                );

                if ($translatedPopularScreenplay !== null) {
                    $translatedPopularScreenplay->isPopular = true;

                    $translatedPopularScreenplay->save();
                }
            }
        }
    }
}
