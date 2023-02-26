<?php

namespace App\Exceptions;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Psr\Log\LogLevel;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        MovieNotFoundException::class => LogLevel::INFO,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $e)
    {
         parent::report($e);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);

        if (
            !app()->environment(['local', 'testing']) &&
            in_array($response->status(), [500, 503, 404, 403])
        ) {
            return Inertia::render('Exceptions/Error', [
                'status' => $response->status(),
            ])
                ->toResponse($request)
                ->setStatusCode($response->status());
        } elseif ($response->status() === 419) {
            return redirect(RouteServiceProvider::HOME);
        } elseif ($response->status() === 400) {
            $exception = $response->exception;

            if($exception !== null) {
                return redirect()->back()->with(['message' => $exception->getMessage()]);
            }

        }

        return $response;
    }
}
