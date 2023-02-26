<?php

namespace App\Classes\TMDB;

use App\Contracts\TMDB\EventDispatcherConfiguratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class StandardEventDispatcherConfigurator implements EventDispatcherConfiguratorInterface
{
    public function configure(
        EventDispatcherInterface &$eventDispatcher,
        array                    $eventListeners = []
    ): void {
        foreach ($eventListeners as $eventName => $listeners) {
            foreach ($listeners as $listener) {
                $eventDispatcher->addListener($eventName, $listener);
            }
        }
    }
}
