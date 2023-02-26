<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class ScreenplayNotFoundException extends Exception
{
    /** @var class-string */
    protected string $class;

    /** @var positive-int */
    protected int $id;

    public function __construct(
        string     $screenplayClass,
        int        $screenplayId,
        string     $message = '',
        int        $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param  class-string  $class
     * @param  int           $id
     *
     * @return static
     */
    public static function withClass(string $class, int $id): self
    {
        $message = sprintf(
            'screenplay of type %s with id #%u has not been found.',
            $class,
            $id
        );

        return new self($class, $id, $message);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
