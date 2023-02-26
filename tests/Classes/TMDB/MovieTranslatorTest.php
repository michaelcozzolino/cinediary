<?php

declare(strict_types=1);

namespace Tests\Services;

use App\Classes\TMDB\MovieTranslator;
use App\Contracts\TMDB\FetcherInterface;
use App\Exceptions\MovieNotFoundException;
use App\Models\Movie;
use Illuminate\Support\Facades\App;
use Mockery;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class MovieTranslatorTest extends TestCase
{
    protected FetcherInterface&MockObject $screenplayFetcher;

    protected MovieTranslator $movieTranslator;

    protected function setUp(): void
    {
        $this->screenplayFetcher = $this->createMock(FetcherInterface::class);
        $this->movieTranslator = new MovieTranslator($this->screenplayFetcher);
        parent::setUp();
    }

    public function testFirstOrTranslateWhenMovieIsFound()
    {
        $movieFacadeMock = Mockery::mock(Movie::class);
        App::instance(Movie::class, $movieFacadeMock);

        $movieMock = Mockery::mock(Movie::class);
        $movieMock->shouldReceive('getAttribute')->with('id')->andReturn(1);
        $movieMock->shouldReceive('getAttribute')
                  ->with('title')
                  ->andReturn('{"en":"Love at Stake","it":"Amore di strega"}');

        $movieFacadeMock->shouldReceive('findOr')
                  ->once()
                  ->with([1, fn () => throw new MovieNotFoundException()])
                    ->andReturn($movieMock);

        $this->movieTranslator->firstOrTranslate(1, ['en', 'it']);

    }

    public function dataProviderForIsFieldTranslatable(): array
    {
        return [
            ['id', false],
            ['title', true],
        ];
    }

    /**
     * @dataProvider dataProviderForIsFieldTranslatable
     *
     * @param  string  $field
     * @param  bool    $isTranslatable
     *
     * @return void
     */
    public function testIsFieldTranslatable(string $field, bool $isTranslatable): void
    {
        self::assertSame($isTranslatable, $this->movieTranslator->isFieldTranslatable($field));
    }
}
