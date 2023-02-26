<?php

declare(strict_types=1);

namespace App\Responses\Diaries;

use App\VO\Diaries\Index\Diary as IndexDiary;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class Index extends Data
{
    public function __construct(
        #[DataCollectionOf(IndexDiary::class)]
        public Lazy|DataCollection $diaries
    ) {

    }
}
