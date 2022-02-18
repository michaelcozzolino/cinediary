<?php


namespace App\Traits;


use App\Classes\TMDBScraper;
use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;

trait ScreenplayActions{

    public function watch(){

        if($this->isToBeWatched())
            $this->removeFromDiary(Diary::toWatch());

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
        return $this->existsInDiary(Diary::favourite());
    }

    public function isToBeWatched(){
        return $this->existsInDiary(Diary::toWatch());
    }

    public function existsInDiary(Diary $diary){
        return (bool) $diary->{$this->getTable()}()->whereId($this->id)->count();
    }

    public function removeFromDiary(Diary $diary){
        if($diary->isWatched())
            $this->diaries()->detach(Diary::favourite()->id);
        $this->diaries()->detach($diary->id);
    }

    public static function getTableName(){
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
