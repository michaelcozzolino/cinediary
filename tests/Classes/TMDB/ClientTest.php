<?php

namespace Tests\Classes\TMDB;

use App\Classes\TMDB\Client as TMDBClient;
use App\Contracts\TMDB\EventDispatcherConfiguratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tests\TestCase;
use Tmdb\Client;

class ClientTest extends TestCase
{
    protected TMDBClient $client;

    protected Client $APIClientMock;

    protected EventDispatcherInterface $eventDispatcherMock;

    protected EventDispatcherConfiguratorInterface $eventDispatcherConfiguratorMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->APIClientMock = $this->createMock(Client::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $this->eventDispatcherConfiguratorMock = $this->createMock(EventDispatcherConfiguratorInterface::class);

    }

    public function api_key_is_valid()
    {
        /** TODO: test */
    }

    /** @test */
    public function it_gets_built()
    {
        $options = [
            'api_token' => 'api-token',
            'event_dispatcher' => [
                'adapter' => $this->eventDispatcherMock,
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

        $this->client = new TMDBClient($options);

        $eventListeners = [];
        $this->eventDispatcherConfiguratorMock->expects(self::once())
                                              ->method('configure')
                                              ->with($this->eventDispatcherMock, $eventListeners);

        $this->client->build($this->eventDispatcherConfiguratorMock, $eventListeners);
    }
}
