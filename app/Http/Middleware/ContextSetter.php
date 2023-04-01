<?php

namespace App\Http\Middleware;

use App\Services\ScreenplayContextService;
use Closure;
use Illuminate\Http\Request;

class ContextSetter
{
    public function __construct(protected ScreenplayContextService $screenplayContext)
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  Request                                                                           $request
     * @param  \Closure(Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $this->screenplayContext->setScreenplayTypeFromRequest($request);

        return $next($request);
    }
}
