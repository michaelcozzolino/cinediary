<?php

declare(strict_types=1);

namespace App\Factories;

use App\Classes\TMDB\Translator;
use App\Models\Screenplay;
use App\Services\ScreenplayService;

/**
 * @extends Factory<ScreenplayService>
 */
class ScreenplayServiceFactory extends Factory
{
    public function __construct(
        protected Translator $translator,
        protected Screenplay $screenplay
    ) {
    }

    public function create(): ScreenplayService
    {
        return new ScreenplayService($this->translator, $this->screenplay);
    }
}
