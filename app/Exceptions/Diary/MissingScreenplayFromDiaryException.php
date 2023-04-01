<?php

declare(strict_types=1);

namespace App\Exceptions\Diary;

use App\Models\Diary;
use App\Models\Screenplay;
use Exception;
use Throwable;

class MissingScreenplayFromDiaryException extends Exception
{
    public function __construct(
        protected Diary $diary,
        protected Screenplay $screenplay,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function withDiary(Diary $diary, Screenplay $screenplay): self
    {
        return new self(
            $diary,
            $screenplay,
            sprintf(
                'Screenplay %s #%d does not exist in %s #%d',
                $screenplay::class,
                $screenplay->id,
                $diary::class,
                $diary->id
            )
        );
    }

    public function getDiary(): Diary
    {
        return $this->diary;
    }

    public function getScreenplay(): Screenplay
    {
        return $this->screenplay;
    }
}
