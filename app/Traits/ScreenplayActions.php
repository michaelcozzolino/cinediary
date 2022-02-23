<?php

namespace App\Traits;

use App\Classes\TMDBScraper;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ScreenplayActions {

    /**
     * Get the screenplay runtime depending if the screenplay is a movie or a series
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function runtime(): Attribute {
        return Attribute::make(
            get: function ($value) {
            return $this instanceof Movie ?
                $value . " minutes" :
                ($this instanceof Series ? $value . " minutes/episode" : $value);
            }
        );
    }

    public function watch(){

        if($this->isToBeWatched())
            $this->removeFromDiary(Diary::getToWatch());

    }

    public function makeFavourite(){
        if(!$this->isWatched())
            $this->addToDiary(Diary::getWatched());
    }

    public function toBeWatched(){
        $this->removeFromDiary(Diary::getWatched());
    }

    public function addToDiary(Diary $diary){
        if(!$this->existsInDiary($diary)) {
            if ($diary->isFavourite())
                $this->makeFavourite();
            elseif ($diary->isWatched())
                $this->watch();
            elseif ($diary->isToWatch())
                $this->toBeWatched();

            $diary->{$this->getTable()}()->attach($this->id);
        }
    }

    public function isWatched(){
        return $this->existsInDiary(Diary::getWatched());
    }

    public function isFavourite(){
        return $this->existsInDiary(Diary::getFavourite());
    }

    public function isToBeWatched(){
        return $this->existsInDiary(Diary::getToWatch());
    }

    public function existsInDiary(Diary $diary){
        return (bool) $diary->{$this->getTable()}()->whereId($this->id)->count();
    }

    public function removeFromDiary(Diary $diary){
        if($diary->isWatched())
            $this->diaries()->detach(Diary::getFavourite()->id);
        $this->diaries()->detach($diary->id);
    }

    public static function getModelClassName(){
        return strtolower((new \ReflectionClass(self::class))->getShortName());
    }

    public static function firstOrTranslate(TMDBScraper $TMDBScraper, $id) : Movie|Series|null {
        $screenplayClass = get_called_class();
        $screenplayTranslations = $TMDBScraper->translate($id, new $screenplayClass());
        if($screenplayClass && !is_null($screenplayTranslations))
            return self::firstOrCreate(compact('id'), $screenplayTranslations);

        return null;
    }


}
