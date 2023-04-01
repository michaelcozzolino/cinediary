<?php

declare(strict_types=1);

namespace App\Contracts\TMDB;

use Illuminate\Support\Collection;
use Tmdb\Model\AbstractModel;

interface ParserInterface
{
    public function parseOne(AbstractModel $model): array;

    /**
     * @param  array<AbstractModel>  $models
     *
     * @return Collection
     */
    public function parseMany(array $models): Collection;
}
