<?php

namespace App\Contracts\TMDB;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherConfiguratorInterface
{
    public function configure(
        EventDispatcherInterface &$eventDispatcher,
        array $eventListeners = []
    ): void;
}
