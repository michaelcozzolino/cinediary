<?php
namespace App\Classes;

use App\Models\Movie;
use App\Models\Series;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ScreenplayActions;
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


class TMDBScraper{

    private ?string $apiKey;
    private string $language;
    private Client $client;
    private const IMAGE_URL = "http://image.tmdb.org/t/p/";
    private const POSTER_PATH_SIZE = "w500";
    private const BACKDROP_PATH_SIZE = "original";
    private array $repositories;
    private array $queries;
    public const DEFAULT_API_KEY = "7bff79e50491c5c1166a4497606d5ad3";
    public const BLANK_POSTER_PATH_URL = "/css/images/reel.png";
    public const BLANK_BACKDROP_PATH_URL = "/css/images/header.png";
    private ?User $user;
    private ?Setting $userSettings;
    public function __construct(string $apiKey = null) {

        $this->language = app()->getLocale();
        $this->user = \Auth::user();
        $this->userSettings = is_null($this->user) ? null : $this->user->settings;
        $this->setApiKey($apiKey ??
            (is_null($this->userSettings)
                ? self::DEFAULT_API_KEY
                : ($this->userSettings->TMDBApiKey ?? self::DEFAULT_API_KEY)));



    }

    public function isApiKeyValid(){
        try {
            $this->client->getMoviesApi()->getMovie(550);
        } catch(TmdbApiException $e) {
            if($e->getCode() === TmdbApiException::STATUS_INVALID_API_KEY)
                return false;
        }
        return true;
    }



    public function translate(int|string $id, Movie|Series $screenplayModel, array $languages = []) : ?array {

        if(empty($language))
            $languages = config('app.available_locales');

        $translatedScreenplayData = [];
        $screenplay = null;
        $screenplayType = $this->getScreenplayType($screenplayModel);
        foreach ($languages as $language) {

            try {
                $screenplay = $this->repositories['get'][$screenplayType]->load($id, compact('language'));
                $translatedScreenplayData['backdropPath'][$language] =
                    $this->getImageUrl($screenplay->getBackdropPath() , self::BACKDROP_PATH_SIZE, false);
                $translatedScreenplayData['posterPath'][$language] =  $this->getImageUrl($screenplay->getPosterPath(), self::POSTER_PATH_SIZE);
                $translatedScreenplayData['overview'][$language] = $screenplay->getOverview();

                $translatedScreenplayData['title'][$language] = method_exists($screenplay,'getTitle') ?
                    $screenplay->getTitle() : $screenplay->getName();
                $translatedScreenplayData['genre'][$language] = $this->getFirstGenre($screenplay);


            } catch (TmdbApiException $e) {
                return null;
            }
        }

        $translatedScreenplayData['originalTitle'] = method_exists($screenplay, 'getOriginalTitle') ?
            $screenplay->getOriginalTitle() : $screenplay->getOriginalName();
        $translatedScreenplayData['id'] = $screenplay->getId();
        $translatedScreenplayData['releaseDate'] = method_exists($screenplay, 'getReleaseDate') ?
            $screenplay->getReleaseDate() : $screenplay->getFirstAirDate() ;

        return $translatedScreenplayData;
    }

    /*
     * it returns only the first genre from a collection of genres of a screenplay
     * */
    private function getFirstGenre(\Tmdb\Model\Movie|Tv $screenplay) : ?string {
        $genres = $screenplay->getGenres()->getGenres();
        return count($genres) ? $genres[0]->getName() : null;
    }

    public function search($query){
        $movies = $this->searchMovies($query);
        $series = $this->searchSeries($query);
        return $this->collect(compact('movies','series'));
    }

    public function searchMovies($query){
        return $this->repositories['search']->searchMovie($query, $this->queries['search']['movies'])->getAll();

    }

    public function searchSeries($query){
        return $this->repositories['search']->searchTv($query, $this->queries['search']['series'])->getAll();

    }

    private function collect(array $data): Collection {
        $screenplays = [];
        foreach ($data as $screenplayType => $jsonScreenplays) {
            $screenplays [$screenplayType] = new Collection();
            foreach ($jsonScreenplays as $jsonScreenplay) {
                $screenplays [$screenplayType]->push([
                    'id' => $jsonScreenplay->getId(),
                    'title' => method_exists($jsonScreenplay, 'getTitle') ?
                        $jsonScreenplay->getTitle() : $jsonScreenplay->getName(),
                    'posterPath' => $this->getImageUrl($jsonScreenplay->getPosterPath(), self::POSTER_PATH_SIZE),
                ]);
            }
        }
        return new Collection($screenplays);
    }


    private function getImageUrl($path, $size, $isPoster = true){
        return $path === null ?
            ($isPoster ? self::BLANK_POSTER_PATH_URL : self::BLANK_BACKDROP_PATH_URL) :
            self::IMAGE_URL . $size . $path;
    }

    private function getScreenplayType(Movie|Series $screenplayModel){
        return $screenplayModel->getTable();
    }

    public function getPopular(Movie|Series $screenplayModel){
        return $this->repositories['get'][$this->getScreenplayType($screenplayModel)]->getPopular()->getAll();
    }



    private function guardAgainstClientWorksProperly(){
        if(!$this->isApiKeyValid())
            throw new \Exception(
                'The client does not work properly,
                this can be due to a wrong api key or ineternet connection error');
    }

    public function setApiKey(string $apiKey){
        $this->apiKey = $apiKey;
        $this->configureClient();

    }

    private function configureClient(){
        $ed = new EventDispatcher();
        $this->client = new Client(
            [
                /** @var ApiToken|BearerToken */
                'api_token' => $this->apiKey,
                'event_dispatcher' => [
                    'adapter' => $ed
                ],
                // We make use of PSR-17 and PSR-18 auto discovery to automatically guess these, but preferably set these explicitly.
                'http' => [
                    'client' => null,
                    'request_factory' => null,
                    'response_factory' => null,
                    'stream_factory' => null,
                    'uri_factory' => null,
                ]
            ]
        );

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
            ]
        ];
        $includeAdult = is_null($this->userSettings) ? false : $this->userSettings->includeAdult;
        $this->queries = [
            'search' => [
                'movies' => (new MovieSearchQuery())->language($this->language)->includeAdult($includeAdult),
                'series' => (new TvSearchQuery())->language($this->language)->filterAdult($includeAdult),
            ]
        ];

    }

    public function getApiKey(){
        return $this->apiKey;
    }


}
