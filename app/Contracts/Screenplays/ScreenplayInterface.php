<?php

namespace App\Contracts\Screenplays;

use App\Models\Diary;

interface ScreenplayInterface
{
    public function existsInDiary(Diary $diary);

    public function removeFromDiary(Diary $diary);

    public function addToDiary(Diary $diary);
}
