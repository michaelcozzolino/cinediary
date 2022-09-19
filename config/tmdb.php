<?php

use Symfony\Component\EventDispatcher\EventDispatcher;

    return [
        'api_token' => env('TMDB_API_KEY'),
        'event_dispatcher' => [
            'adapter' => app()->make(EventDispatcher::class),
        ],
        // We make use of PSR-17 and PSR-18 auto discovery to automatically guess these,
        // but preferably set these explicitly.
        'http' => [
            'client' => null,
            'request_factory' => null,
            'response_factory' => null,
            'stream_factory' => null,
            'uri_factory' => null,
        ],
    ];
