<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\Diary;
use App\Services\DiaryService;

class DiaryHelper
{
    public static function getDiaryService(array $diaryServices, Diary|string $diary): DiaryService
    {
        $diaryType = $diary instanceof Diary ? $diary->type : $diary;
        /** TODO: throw exception */
        return $diaryServices[$diaryType];
    }
}
