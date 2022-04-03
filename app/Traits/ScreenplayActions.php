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
     * Get the screenplay runtime depending if the screenplay is a movie or a series.
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

    /**
     * Add screenplay to the watched diary and remove it from the to watched one.
     */
    public function watch()
    {
        $this->removeFromDiary(\Auth::user()->to_be_watched_diary);
        $this->addToDiary(\Auth::user()->watched_diary);
    }

    /**
     * Add screenplay to the watched and favourite diaries.
     */
    public function makeFavourite()
    {
        $this->watch();
        $this->addToDiary(\Auth::user()->favourite_diary);
    }

    /**
     * Remove screenplay from the favourite diary.
     */
    public function notFavouriteAnymore()
    {
        $this->removeFromDiary(\Auth::user()->favourite_diary);
    }

    /**
     * Remove screenplay from the favourite and watched diaries.
     */
    public function unWatch()
    {
        $this->notFavouriteAnymore();
        $this->removeFromDiary(\Auth::user()->watched_diary);
    }

    /**
     * Unwatch and add the screenplay to the to be watched diary.
     */
    public function toBeWatched()
    {
        $this->unWatch();
        $this->addToDiary(\Auth::user()->to_be_watched_diary);
    }

    /**
     * Add the screenplay to a given diary.
     *
     * @param Diary $diary
     */
    private function addToDiary(Diary $diary)
    {
        $diary->{$this->getTable()}()->syncWithoutDetaching([$this->id]);
    }

    /**
     * Track the screenplay in a given diary.
     *
     * @param Diary $diary
     */
    public function track(Diary $diary)
    {
        if (!$this->existsInDiary($diary)) {
            if ($diary->isFavourite()) {
                $this->makeFavourite($diary);
            } elseif ($diary->isWatched()) {
                $this->watch($diary);
            } elseif ($diary->isToBeWatched()) {
                $this->toBeWatched($diary);
            } else {
                $this->addToDiary($diary);
            }

            session()->flash(
                'message',
                __('flash.screenplay_added', [
                    'screenplay_title' => $this->title,
                    'diary_name' => $diary->isMain ? __($diary->name) : $diary->name,
                ]),
            );
        }
    }

    /**
     * Check if the screenplay is in the watched diary.
     *
     * @return bool
     */
    public function isWatched()
    {
        return $this->existsInDiary(\Auth::user()->watched_diary);
    }

    /**
     * Check if the screenplay is in the favourite diary.
     *
     * @return bool
     */
    public function isFavourite()
    {
        return $this->existsInDiary(\Auth::user()->favourite_diary);
    }

    /**
     * Check if screenplay is in the to be watched diary.
     *
     * @return bool
     */
    public function isToBeWatched()
    {
        return $this->existsInDiary(\Auth::user()->to_be_watched_diary);
    }

    /**
     * Check if the screenplay is in a given diary.
     *
     * @param Diary $diary
     * @return bool
     */
    public function existsInDiary(Diary $diary)
    {
        return (bool) Diary::whereId($diary->id)
            ->whereHas($this->getTable(), function ($builder) {
                $builder->where(self::getModelClassName() . '_id', '=', $this->id);
            })
            ->count();
    }

    /**
     * Remove the screenplay from a given diary.
     *
     * @param Diary $diary
     */
    public function removeFromDiary(Diary $diary)
    {
        if ($diary->isWatched()) {
            $this->notFavouriteAnymore();
        }
        $this->diaries()->detach($diary->id);
        session()->flash('message', __('flash.screenplay_removed', ['screenplay_title' => $this->title]));
    }

    /**
     * Get the name of the model using this trait.
     *
     * @return string
     */
    public static function getModelClassName()
    {
        return strtolower((new \ReflectionClass(self::class))->getShortName());
    }

    /**
     * Get the screenplay matching the given id or translate it.
     *
     * @param TMDBScraper $TMDBScraper
     * @param $id
     * @return Movie|Series|null
     */
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
