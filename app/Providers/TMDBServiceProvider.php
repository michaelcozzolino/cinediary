<?php

namespace App\Providers;

use App;
use App\Classes\StorePopularScreenplays;
use App\Classes\TMDB\Client as TMDBClient;
use App\Classes\TMDB\MovieFetcher;
use App\Classes\TMDB\MovieSearcher;
use App\Classes\TMDB\MoviesParser;
use App\Classes\TMDB\SeriesFetcher;
use App\Classes\TMDB\SeriesParser;
use App\Classes\TMDB\SeriesSearcher;
use App\Classes\TMDB\StandardEventDispatcherConfigurator;
use App\Classes\TMDB\Translator;
use App\Contracts\TMDB\EventDispatcherConfiguratorInterface;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeriesController;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tmdb\Event\BeforeRequestEvent;
use Tmdb\Event\Listener\Request\AcceptJsonRequestListener;
use Tmdb\Event\Listener\Request\ApiTokenRequestListener;
use Tmdb\Event\Listener\Request\ContentTypeJsonRequestListener;
use Tmdb\Event\Listener\Request\UserAgentRequestListener;
use Tmdb\Event\Listener\RequestListener;
use Tmdb\Event\RequestEvent;
use Tmdb\Repository\SearchRepository;

class TMDBServiceProvider extends ServiceProvider
{
    public const TMDB_CONFIG_FILE_NAME = 'tmdb';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
/*        $this->app->singleton(
            UserRepository::class, fn() => new UserRepository($this->app, $this->app->make(App\Models\User::class))
        );*/

        $this->app->bind(EventDispatcherInterface::class, fn () => new EventDispatcher());
        $this->app->bind(Model::class, App\Models\Movie::class);
        $this->app->bind(Model::class, App\Models\User::class);
        $clientParameters = config(self::TMDB_CONFIG_FILE_NAME);

        $this->app->singleton(TMDBClient::class, fn () => new TMDBClient($clientParameters));

        /** @var TMDBClient $TMDBClient */
        try {
            $TMDBClient = $this->app->make(TMDBClient::class);
        } catch (BindingResolutionException $e) {
        }

        $this->app->singleton(
            EventDispatcherConfiguratorInterface::class,
            fn () => new StandardEventDispatcherConfigurator()
        );

        $this->app->singleton(
            RequestListener::class,
            fn (Application $app) => new RequestListener(
                $TMDBClient->getHttpClient(),
                $clientParameters['event_dispatcher']['adapter']
            )
        );

        $this->app->singleton(
            ApiTokenRequestListener::class,
            fn (Application $app) => new ApiTokenRequestListener(
                $TMDBClient->getToken()
            )
        );

        $this->app->singleton(
            AcceptJsonRequestListener::class,
            fn () => new AcceptJsonRequestListener()
        );

        $this->app->singleton(
            AcceptJsonRequestListener::class,
            fn () => new AcceptJsonRequestListener()
        );

        $this->app->singleton(
            ContentTypeJsonRequestListener::class,
            fn () => new ContentTypeJsonRequestListener()
        );

        $this->app->singleton(
            UserAgentRequestListener::class,
            fn () => new UserAgentRequestListener()
        );

        $eventListeners = [
            RequestEvent::class => [$this->app->make(RequestListener::class)],
            BeforeRequestEvent::class => [
                $this->app->make(ApiTokenRequestListener::class),
                $this->app->make(AcceptJsonRequestListener::class),
                $this->app->make(ContentTypeJsonRequestListener::class),
                $this->app->make(UserAgentRequestListener::class),
            ],
        ];

        $TMDBClient->build(
            $this->app->make(EventDispatcherConfiguratorInterface::class),
            $eventListeners
        );

        $this->app->singleton(
            SearchRepository::class,
            fn () => new SearchRepository($TMDBClient)
        );

        $searchRepository = $this->app->make(SearchRepository::class);

        $this->app->singleton(
            MovieSearcher::class,
            fn () => new MovieSearcher($TMDBClient, $searchRepository)
        );

        $this->app->singleton(MoviesParser::class, fn () => new MoviesParser());

        $movieFetcher = new MovieFetcher(
            $this->app->make(MovieSearcher::class),
            $this->app->make(MoviesParser::class),
        );

        $movieTranslator = new Translator($movieFetcher);

        $seriesFetcher = new SeriesFetcher(
            new SeriesSearcher($TMDBClient, $searchRepository),
            new SeriesParser(),
        );

        $seriesTranslator = new Translator($seriesFetcher);

        $screenplayRepositories = [
            $movieFetcher,
            $seriesFetcher,
        ];

        $translators = [
            $movieTranslator,
            $seriesTranslator,
        ];

        /*   $this->app->bind(
               StorePopularScreenplays::class,
               function () use ($screenplayRepositories, $translators) {
                   return new StorePopularScreenplays($screenplayRepositories, $translators);
               }
           );*/

        $this->app->when([SearchController::class, StorePopularScreenplays::class])
                  ->needs('$TMDBScreenplayRepositories')
                  ->give(function ($app) use ($screenplayRepositories) {
                      return $screenplayRepositories;
                  });

        $this->app->bind(MoviesController::class, function () use ($movieFetcher, $movieTranslator) {
            return new MoviesController($movieFetcher, $movieTranslator);
        });

        $this->app->bind(SeriesController::class, function () use ($seriesFetcher, $seriesTranslator) {
            return new MoviesController($seriesFetcher, $seriesTranslator);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
