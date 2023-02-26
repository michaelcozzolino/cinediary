<?php

namespace App\Classes\TMDB;

use App\Contracts\TMDB\ScreenplayParserInterface;
use Illuminate\Support\Collection;
use Tmdb\Model\AbstractModel;

abstract class ScreenplayParser implements ScreenplayParserInterface
{
    public const BLANK_POSTER_PATH_URL = '/images/reel.png';

    public const BLANK_BACKDROP_PATH_URL = '/images/header.jpg';

    public const IMAGE_URL = 'http://image.tmdb.org/t/p/';

    public const POSTER_PATH_SIZE = 'w500';

    public const BACKDROP_PATH_SIZE = 'original';

    /**
     * Create the image url for a screenplay based on the given parameters.
     *
     * @param string|null $path
     * @param string $size
     * @param bool $isPoster
     * @return string
     */
    protected function parseImageUrl(
        ?string $path,
        string $size,
        bool $isPoster = true
    ) {
        return $path === null
            ? ($isPoster
                ? self::BLANK_POSTER_PATH_URL
                : self::BLANK_BACKDROP_PATH_URL)
            : self::IMAGE_URL . $size . $path;
    }

    /**
     * Get the first genre from a list of genres of a screenplay.
     *
     * @param AbstractModel $screenplay
     * @return string|null
     */
    protected function parseFirstGenre(AbstractModel $screenplay)
    {
        $genres = $screenplay->getGenres()->getGenres();

        return count($genres) ? $genres[0]->getName() : null;
    }

    /**
     * @param $screenplay
     * @return array
     */
    public function parseOne($screenplay): array
    {
        return [
            'id' => $screenplay->getId(),
            'title' => $this->parseTitle($screenplay),
            'overview' => $screenplay->getOverview(),
            'genre' => $this->parseFirstGenre($screenplay),
            'posterPath' => $this->parseImageUrl(
                $screenplay->getPosterPath(),
                self::POSTER_PATH_SIZE
            ),
            'backdropPath' => $this->parseImageUrl(
                $screenplay->getBackdropPath(),
                self::BACKDROP_PATH_SIZE
            ),
            'runtime' => $this->parseRuntime($screenplay),
        ];
    }

    /**
     * @param array $screenplays
     * @return Collection
     */
    public function parseMany(array $screenplays): Collection
    {
        $parsedScreenplays = new Collection();

        foreach ($screenplays as $screenplay) {
            $parsedScreenplays->push($this->parseOne($screenplay));
        }

        return $parsedScreenplays;
    }

    abstract public function parseTitle(AbstractModel $screenplay): string;

    /**
     * Get the release date of a screenplay if available.
     *
     * @param AbstractModel $screenplay
     * @return \DateTime|null
     */
    abstract public function parseReleaseDate(
        AbstractModel $screenplay
    ): ?\DateTime;

    /** @noinspection PhpPossiblePolymorphicInvocationInspection */
    abstract public function parseRuntime(AbstractModel $screenplay): int;
}
