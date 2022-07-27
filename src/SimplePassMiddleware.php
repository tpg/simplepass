<?php

declare(strict_types=1);

namespace TPG\Simple;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use TPG\Simple\Contracts\SimplePassInterface;

class SimplePassMiddleware
{
    public function __construct(protected SimplePassInterface $simplePass)
    {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->simplePass->shouldIgnore($request)) {
            return $next($request);
        }

        if ($this->simplePass->enabled()) {
            if ($request->has('logout')) {
                $this->simplePass->logout($request);

                return redirect()->refresh()->withCookies(Cookie::getQueuedCookies());
            }

            if (! $this->simplePass->check($request)) {
                Redirect::setIntendedUrl($request->url());

                return redirect()->route('simplepass.login');
            }
        }

        return $next($request);
    }
}
