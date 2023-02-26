<?php

declare(strict_types=1);

namespace App\VO\Screenplays;

use App\Models\Diary;
use App\Repositories\ScreenplayRepository;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ScreenplayContext
{
    /**
     * @param  string        $type
     * @param  class-string  $class
     * @param  string        $table
     */
    public function __construct(
        public string $type,
        public string $class,
        public string $table,
        public ScreenplayRepository $repository
    ) {

    }

    public function getDiaryRelation(Diary $diary): ?MorphToMany
    {
        $table = $this->table;

        return $table !== null ? $diary->{$table}() : null;
    }
}
