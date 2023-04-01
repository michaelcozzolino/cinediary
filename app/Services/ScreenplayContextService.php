<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Movie;
use App\Models\Series;
use App\VO\Screenplays\ScreenplayContext;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScreenplayContextService
{
    protected ?ScreenplayContext $screenplayContext;

    /**
     * @param  class-string|null  $class
     */
    public function __construct(protected ?string $class = null)
    {
        $this->setScreenplayContextFromClass($this->class);
    }

    /**
     * @return class-string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    protected function setScreenplayContextFromClass(?string $class): void
    {
        $this->class = $class;

        $this->screenplayContext = self::getScreenplayContextFromClass($class);
    }

    public function getScreenplayContext(): ?ScreenplayContext
    {
        return $this->screenplayContext;
    }

    public function setScreenplayTypeFromRequest(Request $request): void
    {
        $routePrefix = $request->route()->getName() ?? '';
        /** TODO: throw */
        $availableTypes = self::getAvailableTypes();
        foreach ($availableTypes as $availableScreenplayType => $availableScreenplayTypeClass) {
            if (Str::contains($routePrefix, $availableScreenplayType)) {
                $this->setScreenplayContextFromClass($availableScreenplayTypeClass);
                break;
            }
        }

    }

    public static function getAvailableTypes(): array
    {
        return config('app.screenplay_types');
    }

    /**
     * @return array<Movie | Series>
     */
    public static function getAllModels(): array
    {
        $screenplayModels = [];

        $screenplayTypes = self::getAvailableTypes();
        foreach ($screenplayTypes as $screenplayType) {
            $screenplayModels[] = new $screenplayType();
        }

        return $screenplayModels;
    }

    /**
     * @return array<string>
     */
    public static function getTableNames(): array
    {
        $screenplayTableNames = [];

        $screenplayModels = self::getAllModels();

        foreach ($screenplayModels as $screenplayModel) {
            $screenplayTableNames[] = $screenplayModel->getTable();
        }

        return $screenplayTableNames;
    }

    public static function getTableFromClass(string $class): string
    {
        return (new $class())->getTable();
    }

    public static function getRepositories(): array
    {
        return config('app.screenplay_repositories');
    }

    public static function getRepositoryClassFromClass(string $class): ?string
    {
        return self::getRepositories()[$class] ?? null;
    }

    public static function getScreenplayContextFromClass(?string $class): ?ScreenplayContext
    {
        if($class === null) {
            return  null;
        }

        foreach (self::getAvailableTypes() as $screenplayType => $screenplayClass) {
            if ($class === $screenplayClass) {
                $screenplayRepositoryClass = self::getRepositoryClassFromClass($screenplayClass);
                $screenplayRepository = new $screenplayRepositoryClass();

                return new ScreenplayContext(
                    $screenplayType,
                    $screenplayClass,
                    self::getTableFromClass($screenplayClass),
                    $screenplayRepository
                );
            }
        }

        return null;
    }
}
