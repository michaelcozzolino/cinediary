<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfEmptyDiaries
{
    public const ERROR_MESSAGE = 'You have neither movies nor series added to your diaries,
                you can start here by searching some!';
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $diaries = \Auth::user()->load('diaries')->diaries;

        foreach ($diaries as $diary) {
            if ($diary->movies->count() || $diary->series->count()) {
                return $next($request);
            }
        }

        return redirect()
            ->route('search.create')
            ->with(['message' => self::ERROR_MESSAGE]);
    }
}
