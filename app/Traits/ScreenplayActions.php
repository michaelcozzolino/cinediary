<?php

namespace App\Traits;

use App\Classes\TMDBScraper;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ScreenplayActions
{
    /**
     * Get the screenplay runtime depending if the screenplay is a movie or a series
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function runtime(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this instanceof Movie
                    ? $value . ' ' . __('minutes')
                    : ($this instanceof Series
                        ? $value . ' ' . __('minutes/episode')
                        : $value);
            },
        );
    }

    public function watch()
    {
        if ($this->isToBeWatched()) {
            $this->removeFromDiary(Diary::toBeWatched()->first());
        }
    }

    public function makeFavourite()
    {
        if (!$this->isWatched()) {
            //            $this->addToDiary(Diary::where('name', Diary::WATCHED_DIARY_NAME)->main()->first());
            $this->addToDiary(Diary::watched()->first());
        }
    }

    public function toBeWatched()
    {
        $this->removeFromDiary(Diary::watched()->first());
    }

    public function addToDiary(Diary $diary)
    {
        if (!$this->existsInDiary($diary)) {
            if ($diary->isFavourite()) {
                $this->makeFavourite();
            } elseif ($diary->isWatched()) {
                $this->watch();
            } elseif ($diary->isToBeWatched()) {
                $this->toBeWatched();
            }

            $diary->{$this->getTable()}()->attach($this->id);
            session()->flash(
                'message',
                __('flash.screenplay_added', [
                    'screenplay_title' => $this->title,
                    'diary_name' => $diary->isMain ? __($diary->name) : $diary->name,
                ]),
            );
        }
    }

    public function isWatched()
    {
        return $this->existsInDiary(Diary::watched()->first());
    }

    public function isFavourite()
    {
        return $this->existsInDiary(Diary::favourite()->first());
    }

    public function isToBeWatched()
    {
        return $this->existsInDiary(Diary::toBeWatched()->first());
    }

    public function existsInDiary(Diary $diary)
    {
        return (bool) Diary::whereId($diary->id)
            ->whereHas($this->getTable(), function ($builder) {
                $builder->where(self::getModelClassName() . '_id', '=', $this->id);
            })
            ->count();
    }

    public function removeFromDiary(Diary $diary)
    {
        if ($diary->isWatched()) {
            $this->diaries()->detach(Diary::favourite()->first()->id);
        }
        $this->diaries()->detach($diary->id);
        session()->flash('message', __('flash.screenplay_removed', ['screenplay_title' => $this->title]));
    }

    public static function getModelClassName()
    {
        return strtolower((new \ReflectionClass(self::class))->getShortName());
    }

    public static function firstOrTranslate(TMDBScraper $TMDBScraper, $id): Movie|Series|null
    {
        $screenplayClass = get_called_class();
        $screenplayTranslations = $TMDBScraper->translate($id, new $screenplayClass());
        if ($screenplayClass && !is_null($screenplayTranslations)) {
            return self::firstOrCreate(compact('id'), $screenplayTranslations);
        }

        return null;
    }
}
