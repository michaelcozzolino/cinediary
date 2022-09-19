<?php

namespace App\Classes\TMDB;

use App\Contracts\TMDB\EventDispatcherConfiguratorInterface;
use Tmdb\ConfigurationInterface;

class Client extends \Tmdb\Client
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
