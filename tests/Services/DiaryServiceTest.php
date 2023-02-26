<?php

declare(strict_types=1);

namespace Tests\Services;

use App\Models\Diary;
use App\Models\Movie;
use App\Models\Screenplay;
use App\Models\Series;
use App\Registries\ScreenplayRegistry;
use App\Services\DiaryService;
use App\Services\MovieService;
use App\Services\UserService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class DiaryServiceTest extends TestCase
{
    protected MockInterface $userServiceMock;

    protected MockInterface $diaryMock;

    protected DiaryService $diaryService;

    /**
     * @var array<Screenplay>
     */
    protected array $screenplays;

    protected MockInterface $movieMock;

    protected MockInterface $screenplayServiceRegistry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userServiceMock = Mockery::mock(UserService::class);

        $this->screenplayServiceRegistry = Mockery::mock(ScreenplayRegistry::class);

        $this->diaryService = new DiaryService(
            $this->userServiceMock,
            $this->screenplayServiceRegistry
        );
    }

    /** TODO: make also for series */
//    public function testDiaryHasScreenplay(): void
//    {
//
//    }

    public function testAddScreenplayWhenScreenplayIsAlreadyInDiary()
    {
        $movieServiceMock = Mockery::mock(MovieService::class);
        $movieMock = Mockery::mock(Movie::class);

        $this->screenplayServiceRegistry->expects('get')
                                        ->with($movieMock::class)
                                        ->andReturn($movieServiceMock);

        $diaryMock = Mockery::mock(Diary::class);
        $movieServiceMock->shouldReceive('isInDiary')
                     ->once()
                     ->with($movieMock, $diaryMock)
                     ->andReturnTrue();

        self::assertSame(
            [],
            $this->diaryService->addScreenplay($diaryMock, $movieMock)
        );
    }
}
