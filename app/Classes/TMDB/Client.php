<?php

declare(strict_types=1);

namespace App\Classes\TMDB;

use App\Contracts\TMDB\EventDispatcherConfiguratorInterface;
use Tmdb\Client as BaseClient;
use Tmdb\ConfigurationInterface;

class Client extends BaseClient
{
    public function __construct(protected ConfigurationInterface|array $options)
    {
        parent::__construct($this->options);
    }

    public function build(
        EventDispatcherConfiguratorInterface $eventDispatcherConfigurator,
        array $eventListeners
    ): void {
        $eventDispatcherConfigurator->configure(
            $this->options['event_dispatcher']['adapter'],
            $eventListeners
        );
    }
}
