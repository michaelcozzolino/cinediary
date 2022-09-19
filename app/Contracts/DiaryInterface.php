<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Screenplay;

interface DiaryInterface
{
    public function addScreenplay(Screenplay $screenplay): void;

    public function removeScreenplay(Screenplay $screenplay): void;
}
