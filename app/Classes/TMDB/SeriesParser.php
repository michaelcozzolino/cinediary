<?php

namespace App\Classes\TMDB;

use Tmdb\Model\AbstractModel;
use Tmdb\Model\Tv;

class SeriesParser extends Parser
{
    /**
     * Get the runtime of the first episode of a series to be represented as the runtime of each episode.
     *
     * @param \Tmdb\Model\Tv $series
     * @return int
     */
    private function parseFirstEpisodeRuntime(Tv $series)
    {
        $episodeRuntime = $series->getEpisodeRunTime();

        return reset($episodeRuntime) !== false ? reset($episodeRuntime) : 0;
    }

    public function parseReleaseDate(AbstractModel $screenplay): ?\DateTime
    {
        return $screenplay->getFirstAirDate();
    }

    public function parseTitle(AbstractModel $screenplay): string
    {
        return $screenplay->getName();
    }

    public function parseRuntime(AbstractModel $screenplay): int
    {
        return $this->parseFirstEpisodeRuntime($screenplay);
    }
}
