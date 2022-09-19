<?php

namespace App\Contracts\Screenplays;

interface Watchable_
{
    public function watch();

    public function notFavouriteAnymore();

    public function toBeWatched();
}
