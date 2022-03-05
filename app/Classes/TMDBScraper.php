<?php

namespace App\Classes;

use App\Models\Movie;
use App\Models\Series;
use App\Models\Setting;
use App\Models\User;
use DateTime;
use Illuminate\Support\Collection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Tmdb\Client;
use Tmdb\Event\BeforeRequestEvent;
use Tmdb\Event\Listener\Request\AcceptJsonRequestListener;
use Tmdb\Event\Listener\Request\ApiTokenRequestListener;
use Tmdb\Event\Listener\Request\ContentTypeJsonRequestListener;
use Tmdb\Event\Listener\Request\UserAgentRequestListener;
use Tmdb\Event\Listener\RequestListener;
use Tmdb\Event\RequestEvent;
use Tmdb\Exception\TmdbApiException;
use Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use Tmdb\Model\Search\SearchQuery\TvSearchQuery;
use Tmdb\Model\Tv;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\SearchRepository;
use Tmdb\Repository\TvRepository;
use Tmdb\Token\Api\ApiToken;
use Tmdb\Token\Api\BearerToken;

class TMDBScraper
{
    private ?string $apiKey;
    private string $language;
    private Client $client;
    private const IMAGE_URL = 'http://image.tmdb.org/t/p/';
    private const POSTER_PATH_SIZE = 'w500';
    private const BACKDROP_PATH_SIZE = 'original';
    private array $repositories;
    private array $queries;
    public const DEFAULT_API_KEY = '7bff79e50491c5c1166a4497606d5ad3';
    public const BLANK_POSTER_PATH_URL = '/images/reel.png';
    public const BLANK_BACKDROP_PATH_URL = '/images/header.jpg';
    private ?User $user;
    private ?Setting $userSettings;

    /**
     * TMDBScraper constructor.
     * @param string|null $apiKey
     */
    public function __construct(string $apiKey = null)
    {
        $this->language = app()->getLocale();
        $this->user = \Auth::user();
        $this->userSettings = is_null($this->user) ? null : $this->user->settings;
        $this->setApiKey(
            $apiKey ??
                (is_null($this->userSettings)
                    ? self::DEFAULT_API_KEY
                    : $this->userSettings->TMDBApiKey ?? self::DEFAULT_API_KEY),
        );
    }

    /**
     * Check if a given api key is valid, by attempting a request.
     *
     * @return bool
     */
    public function isApiKeyValid()
    {
        try {
            $this->client->getMoviesApi()->getMovie(550);
        } catch (TmdbApiException $e) {
            if ($e->getCode() === TmdbApiException::STATUS_INVALID_API_KEY) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the needed screenplay by its id from TMDB with all its translations.
     *
     * @param int|string $id
     * @param \App\Models\Movie|\App\Models\Series $screenplayModel
     * @param array $languages
     * @return array|null
     */
    public function translate(int|string $id, Movie|Series $screenplayModel, array $languages = [])
    {
        if (empty($language)) {
            $languages = config('app.available_locales');
        }

        $translatedScreenplayData = [];
        $screenplay = null;
        $screenplayType = $this->getScreenplayType($screenplayModel);

        foreach ($languages as $language) {
            try {
                $screenplay = $this->repositories['get'][$screenplayType]->load($id, compact('language'));
                $translatedScreenplayData['backdropPath'][$language] = $this->getImageUrl(
                    $screenplay->getBackdropPath(),
                    self::BACKDROP_PATH_SIZE,
                    false,
                );
                $translatedScreenplayData['posterPath'][$language] = $this->getImageUrl(
                    $screenplay->getPosterPath(),
                    self::POSTER_PATH_SIZE,
                );
                $translatedScreenplayData['overview'][$language] = $screenplay->getOverview();

                $translatedScreenplayData['title'][$language] = method_exists($screenplay, 'getTitle')
                    ? $screenplay->getTitle()
                    : $screenplay->getName();
                $translatedScreenplayData['genre'][$language] = $this->getFirstGenre($screenplay);
            } catch (TmdbApiException $e) {
                return null;
            }
        }

        if (!is_null($screenplay)) {
            $translatedScreenplayData['originalTitle'] = method_exists($screenplay, 'getOriginalTitle')
                ? $screenplay->getOriginalTitle()
                : $screenplay->getOriginalName();
            $translatedScreenplayData['id'] = $screenplay->getId();
            $translatedScreenplayData['releaseDate'] = $this->getReleaseDate($screenplay);
            $translatedScreenplayData['runtime'] = method_exists($screenplay, 'getRuntime')
                ? $screenplay->getRuntime()
                : $this->getFirstEpisodeRuntime($screenplay);
        }

        return $translatedScreenplayData;
    }

    /**
     * Get the release date of a screenplay if available.
     *
     * @param \Tmdb\Model\Movie|\Tmdb\Model\Tv $screenplay
     * @return DateTime|null
     */
    private function getReleaseDate(\Tmdb\Model\Movie|Tv $screenplay)
    {
        $releaseDate = method_exists($screenplay, 'getReleaseDate')
            ? $screenplay->getReleaseDate()
            : $screenplay->getFirstAirDate();
        return $releaseDate === '' ? null : $releaseDate;
    }

    /**
     * Get the runtime of the first episode of a series to be represented as the runtime of each episode.
     *
     * @param \Tmdb\Model\Tv $series
     * @return int
     */
    private function getFirstEpisodeRuntime(Tv $series)
    {
        $episodeRuntime = $series->getEpisodeRunTime();
        return reset($episodeRuntime) !== false ? reset($episodeRuntime) : 0;
    }

    /**
     * Get the first genre from a list of genres of a screenplay.
     *
     * @param \Tmdb\Model\Movie|\Tmdb\Model\Tv $screenplay
     * @return string|null
     */
    private function getFirstGenre(\Tmdb\Model\Movie|Tv $screenplay)
    {
        $genres = $screenplay->getGenres()->getGenres();
        return count($genres) ? $genres[0]->getName() : null;
    }

    /**
     * Search and collect both movies and series by a given query.
     *
     * @param string $query
     * @return Collection
     */
    public function search(string $query)
    {
        $movies = $this->searchMovies($query);
        $series = $this->searchSeries($query);
        return $this->collect(compact('movies', 'series'));
    }

    /**
     * Search movies by a given query.
     *
     * @param string $query
     * @return array
     */
    public function searchMovies(string $query)
    {
        return $this->repositories['search']->searchMovie($query, $this->queries['search']['movies'])->getAll();
    }

    /**
     * Search series by a given query.
     *
     * @param string $query
     * @return array
     */
    public function searchSeries(string $query)
    {
        return $this->repositories['search']->searchTv($query, $this->queries['search']['series'])->getAll();
    }

    /**
     * Collect the main data of a screenplay.
     *
     * @param array $data
     * @return Collection
     */
    private function collect(array $data): Collection
    {
        $screenplays = [];
        foreach ($data as $screenplayType => $jsonScreenplays) {
            $screenplays[$screenplayType] = new Collection();
            foreach ($jsonScreenplays as $jsonScreenplay) {
                $screenplays[$screenplayType]->push([
                    'id' => $jsonScreenplay->getId(),
                    'title' => method_exists($jsonScreenplay, 'getTitle')
                        ? $jsonScreenplay->getTitle()
                        : $jsonScreenplay->getName(),
                    'posterPath' => $this->getImageUrl($jsonScreenplay->getPosterPath(), self::POSTER_PATH_SIZE),
                ]);
            }
        }
        return new Collection($screenplays);
    }

    /**
     * Create the image url for a screenplay based on the given parameters.
     *
     * @param string|null $path
     * @param string $size
     * @param bool $isPoster
     * @return string
     */
    private function getImageUrl(?string $path, string $size, bool $isPoster = true)
    {
        return $path === null
            ? ($isPoster
                ? self::BLANK_POSTER_PATH_URL
                : self::BLANK_BACKDROP_PATH_URL)
            : self::IMAGE_URL . $size . $path;
    }

    /** TODO: check if trait can be used */
    private function getScreenplayType(Movie|Series $screenplayModel)
    {
        return $screenplayModel->getTable();
    }

    /**
     * Get the popular screenplays.
     *
     * @param \App\Models\Movie|\App\Models\Series $screenplayModel
     * @return array
     */
    public function getPopular(Movie|Series $screenplayModel)
    {
        return $this->repositories['get'][$this->getScreenplayType($screenplayModel)]->getPopular()->getAll();
    }

    /**
     * Set the api key for the TMDB client.
     *
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->configureClient();
    }

    /**
     * Configure the TMDB Client.
     */
    private function configureClient()
    {
        $ed = new EventDispatcher();
        $this->client = new Client([
            /** @var ApiToken|BearerToken */
            'api_token' => $this->apiKey,
            'event_dispatcher' => [
                'adapter' => $ed,
            ],
            // We make use of PSR-17 and PSR-18 auto discovery to automatically guess these, but preferably set these explicitly.
            'http' => [
                'client' => null,
                'request_factory' => null,
                'response_factory' => null,
                'stream_factory' => null,
                'uri_factory' => null,
            ],
        ]);

        /**
         * Required event listeners and events to be registered with the PSR-14 Event Dispatcher.
         */
        $requestListener = new RequestListener($this->client->getHttpClient(), $ed);
        $ed->addListener(RequestEvent::class, $requestListener);

        $apiTokenListener = new ApiTokenRequestListener($this->client->getToken());
        $ed->addListener(BeforeRequestEvent::class, $apiTokenListener);

        $acceptJsonListener = new AcceptJsonRequestListener();
        $ed->addListener(BeforeRequestEvent::class, $acceptJsonListener);

        $jsonContentTypeListener = new ContentTypeJsonRequestListener();
        $ed->addListener(BeforeRequestEvent::class, $jsonContentTypeListener);

        $userAgentListener = new UserAgentRequestListener();
        $ed->addListener(BeforeRequestEvent::class, $userAgentListener);

        $this->repositories = [
            'search' => new SearchRepository($this->client),
            'get' => [
                'movies' => new MovieRepository($this->client),
                'series' => new TvRepository($this->client),
            ],
        ];
        $includeAdult = is_null($this->userSettings) ? false : $this->userSettings->includeAdult;
        $this->queries = [
            'search' => [
                'movies' => (new MovieSearchQuery())->language($this->language)->includeAdult($includeAdult),
                'series' => (new TvSearchQuery())->language($this->language)->filterAdult($includeAdult),
            ],
        ];
    }

    /**
     * Get the TMDB client api key.
     *
     * @return string|null
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
