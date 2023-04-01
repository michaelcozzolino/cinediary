<?php

declare(strict_types=1);

namespace App\Providers;

use App\Classes\StorePopularScreenplays;
use App\Classes\TMDB\Client as TMDBClient;
use App\Classes\TMDB\MovieParser;
use App\Classes\TMDB\MovieSearcher;
use App\Classes\TMDB\ScreenplayFetcher;
use App\Classes\TMDB\ScreenplayParser;
use App\Classes\TMDB\Searcher;
use App\Classes\TMDB\SeriesParser;
use App\Classes\TMDB\SeriesSearcher;
use App\Classes\TMDB\StandardEventDispatcherConfigurator;
use App\Contracts\TMDB\EventDispatcherConfiguratorInterface;
use App\Contracts\TMDB\FetcherInterface;
use App\Contracts\TMDB\ScreenplayParserInterface;
use App\Contracts\TMDB\Searchable;
use App\Http\Controllers\SearchController;
use App\Models\Movie;
use App\Models\Series;
use App\Registries\FetcherRegistry;
use App\Services\ScreenplayContextService;
use App\Services\Search\Screenplay\ScreenplaySearchService;
use App\Services\SearchServiceInterface;
use App\VO\Providers\Binding;
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
        $clientParameters = config(self::TMDB_CONFIG_FILE_NAME);

//        /** @var TMDBClient $TMDBClient */
//        $TMDBClient = $this->app->make(TMDBClient::class);

        $this->registerSingletons([
            new Binding(TMDBClient::class, fn () => new TMDBClient($clientParameters)),
            new Binding(EventDispatcherInterface::class, fn () => new EventDispatcher()),
            new Binding(
                EventDispatcherConfiguratorInterface::class,
                fn () => new StandardEventDispatcherConfigurator()
            ),
            new Binding(RequestListener::class, fn () => new RequestListener(
                $this->app->make(TMDBClient::class)->getHttpClient(),
                $clientParameters['event_dispatcher']['adapter']
            )),
            new Binding(
                ApiTokenRequestListener::class,
                fn () => new ApiTokenRequestListener(
                    $this->app->make(TMDBClient::class)->getToken()
                )
            ),
            new Binding(AcceptJsonRequestListener::class),
            new Binding(AcceptJsonRequestListener::class),
            new Binding(ContentTypeJsonRequestListener::class),
            new Binding(UserAgentRequestListener::class),
            new Binding(
                ScreenplayContextService::class, fn () => new ScreenplayContextService()
            ),
            new Binding(FetcherRegistry::class),
        ]);

        $eventListeners = [
            RequestEvent::class       => [$this->app->make(RequestListener::class)],
            BeforeRequestEvent::class => [
                $this->app->make(ApiTokenRequestListener::class),
                $this->app->make(AcceptJsonRequestListener::class),
                $this->app->make(ContentTypeJsonRequestListener::class),
                $this->app->make(UserAgentRequestListener::class),
            ],
        ];

        $TMDBClient = $this->app->make(TMDBClient::class);
        $TMDBClient->build(
            $this->app->make(EventDispatcherConfiguratorInterface::class),
            $eventListeners
        );

        $this->app->bind(
            SearchRepository::class,
            fn () => new SearchRepository($TMDBClient)
        );

        $searchRepository = $this->app->make(SearchRepository::class);

        $this->app->bind(Searcher::class, fn () => new Searcher($TMDBClient, $searchRepository));

        $this->app->bind(
            MovieSearcher::class,
            fn () => new MovieSearcher($TMDBClient, $searchRepository)
        );

        $this->app->bind(MovieParser::class, fn () => new MovieParser());

        $this->app->bind(FetcherInterface::class, ScreenplayFetcher::class);
        $this->app->bind(Searchable::class, Searcher::class);
        $this->app->bind(ScreenplayParserInterface::class, ScreenplayParser::class);
        $movieFetcher = new ScreenplayFetcher(
            $this->app->make(MovieSearcher::class),
            $this->app->make(MovieParser::class)
        );

        $seriesFetcher = new ScreenplayFetcher(
            new SeriesSearcher($TMDBClient, $searchRepository),
            new SeriesParser(),
        );

        $screenplayFetchers = [
            Movie::class  => $movieFetcher,
            Series::class => $seriesFetcher,
        ];

        /*   $this->app->bind(
               StorePopularScreenplays::class,
               function () use ($screenplayRepositories, $translators) {
                   return new StorePopularScreenplays($screenplayRepositories, $translators);
               }
           );*/

        $this->app->when([StorePopularScreenplays::class])
                  ->needs('$screenplayFetchers')
                  ->give(function ($app) use ($screenplayFetchers) {
                      return $screenplayFetchers;
                  });

        $this->app->when(SearchController::class)
                  ->needs(SearchServiceInterface::class)
                  ->give(ScreenplaySearchService::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var FetcherRegistry $fetcherRegistry */
        $fetcherRegistry = $this->app->make(FetcherRegistry::class);

        $fetcherRegistry->registerMany([
            Movie::class  => new ScreenplayFetcher(
                app()->make(MovieSearcher::class),
                app()->make(MovieParser::class)
            ),
            Series::class => new ScreenplayFetcher(
                $this->app->make(SeriesSearcher::class),
                $this->app->make(SeriesParser::class)
            ),
        ]
        );

    }
}
