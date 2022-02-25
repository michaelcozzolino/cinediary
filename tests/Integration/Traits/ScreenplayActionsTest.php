<?php

namespace Tests\Integration\Traits;

use App\Models\Diary;
use App\Models\Movie;
use App\Models\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScreenplayActionsTest extends TestCase
{
    use refreshDatabase;
    private Movie $movie;

    protected function setUp(): void
    {
        parent::setUp();

        $this->movie = Movie::factory()->create(['id' => 1]);
        $this->signIn();
    }

    /** @test */
    public function it_can_be_added_to_a_diary()
    {
        $this->movie->addToDiary($this->diaries['custom']);
        $this->assertTrue(
            $this->diaries['custom']
                ->movies()
                ->whereId($this->movie->id)
                ->exists(),
        );
    }

    /** @test */
    public function it_exists_in_a_diary()
    {
        $this->movie->addToDiary($this->diaries['watched']);
        $this->assertTrue($this->movie->existsInDiary($this->diaries['watched']));
    }

    /** @test */
    public function it_can_be_removed_from_a_diary()
    {
        $this->movie->toBeWatched();
        $this->movie->removeFromDiary($this->diaries['toWatch']);
        $this->assertFalse($this->movie->existsInDiary($this->diaries['toWatch']));
    }

    /** @test */
    public function it_can_be_watched()
    {
        $this->movie->addToDiary($this->diaries['toWatch']);
        $this->movie->addToDiary($this->diaries['watched']);
        $this->assertTrue($this->movie->existsInDiary($this->diaries['watched']));
        $this->assertFalse($this->movie->existsInDiary($this->diaries['toWatch']));
    }

    /** @test */
    public function it_can_be_favourite()
    {
        $this->movie->addToDiary($this->diaries['favourite']);
        $this->assertTrue($this->movie->existsInDiary($this->diaries['watched']));
        $this->assertTrue($this->movie->existsInDiary($this->diaries['favourite']));
        $this->assertFalse($this->movie->existsInDiary($this->diaries['toWatch']));
    }

    /** @test */
    public function it_can_be_watched_in_the_future()
    {
        $this->movie->addToDiary($this->diaries['favourite']);
        $this->movie->addToDiary($this->diaries['toWatch']);
        $this->assertTrue($this->movie->existsInDiary($this->diaries['toWatch']));
        $this->assertFalse($this->movie->existsInDiary($this->diaries['favourite']));
        $this->assertFalse($this->movie->existsInDiary($this->diaries['watched']));
    }

    /** @test */
    public function it_can_be_unwatched()
    {
        $this->movie->addToDiary($this->diaries['watched']);
        $this->movie->removeFromDiary($this->diaries['watched']);
        $this->assertFalse($this->movie->existsInDiary($this->diaries['watched']));
        $this->assertFalse($this->movie->existsInDiary($this->diaries['favourite']));
        $this->assertFalse($this->movie->existsInDiary($this->diaries['toWatch']));
    }
}
