<?php

declare(strict_types=1);

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
     * Builds the image url for a screenplay based on the given parameters.
     *
     * @param  string|null  $path
     * @param  string       $size
     * @param  bool         $isPoster
     *
     * @return string
     */
    protected function buildImageUrl(
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
     * @param  AbstractModel  $screenplay
     *
     * @return string|null
     */
    protected function parseFirstGenre(AbstractModel $screenplay)
    {
        $genres = $screenplay->getGenres()->getGenres();

        return count($genres) ? $genres[0]->getName() : null;
    }

    /**
     * @param  AbstractModel  $model
     *
     * @return array<string, string>
     */
    public function parseOne(AbstractModel $model): array
    {
        return [
            'id'           => $model->getId(),
            'title'        => $this->parseTitle($model),
            'overview'     => $model->getOverview(),
            'genre'        => $this->parseFirstGenre($model),
            'posterPath'   => $this->buildImageUrl(
                $model->getPosterPath(),
                self::POSTER_PATH_SIZE
            ),
            'backdropPath' => $this->buildImageUrl(
                $model->getBackdropPath(),
                self::BACKDROP_PATH_SIZE
            ),
            'runtime'      => $this->parseRuntime($model),
        ];
    }

    /**
     * @param  array<AbstractModel>  $models
     *
     * @return Collection
     */
    public function parseMany(array $models): Collection
    {
        $parsedScreenplays = new Collection();

        foreach ($models as $screenplay) {
            $parsedScreenplays->push($this->parseOne($screenplay));
        }

        return $parsedScreenplays;
    }

    abstract public function parseTitle(AbstractModel $screenplay): string;

    /**
     * Get the release date of a screenplay if available.
     *
     * @param  AbstractModel  $screenplay
     *
     * @return \DateTime|null
     */
    abstract public function parseReleaseDate(AbstractModel $screenplay): ?\DateTime;

    abstract public function parseRuntime(AbstractModel $screenplay): int;
}
