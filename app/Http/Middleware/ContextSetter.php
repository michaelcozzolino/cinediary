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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $this->screenplayContext->setScreenplayTypeFromRequest($request);

        return  $next($request);
    }
}
