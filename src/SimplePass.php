<?php

declare(strict_types=1);

namespace TPG\Simple;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use TPG\Simple\Contracts\SimplePassInterface;

class SimplePass implements SimplePassInterface
{
    public function attempt(Request $request): bool
    {
        if ($this->check($request)) {
            return true;
        }

        $password = $request->get('password');

        $hash = base64_decode(Str::after(config('simplepass.secret'), 'base64:'));

        if (Hash::check($password, $hash)) {
            Cookie::queue($this->cookieName(), $password, config('simplepass.duration'));

            return true;
        }

        $this->logout($request);

        return false;
    }

    public function check(Request $request): bool
    {
        $enc = $request->cookie($this->cookieName(), false);

        return $enc || $enc === $request->get('pass');
    }

    public function logout(Request $request): void
    {
        Cookie::expire($this->cookieName());
    }

    public function shouldIgnore(Request $request): bool
    {
        if (! config('simplepass.ignore')) {
            return false;
        }

        return $request->fullUrlIs(config('simplepass.ignore'));
    }

    public function enabled(): bool
    {
        return config('simplepass.secret') && config('simplepass.enabled');
    }

    protected function cookieName(): string
    {
        return 'simple-pass-auth';
    }

    public function bootRoutes(): void
    {
        Route::get('simplepass/auth', function (Request $request) {
            if (! $this->enabled()) {
                $this->logout($request);

                return redirect()->to(config('simplepass.redirect'));
            }

            if ($this->check($request)) {
                return redirect()->to(config('simplepass.redirect', '/'));
            }

            return view(config('simplepass.view'));
        })->name('simplepass.login');

        Route::post('simplepass/auth', function (Request $request) {
            if ($this->attempt($request)) {
                return redirect()->intended()->withCookies(Cookie::getQueuedCookies());
            }

            return redirect()->route('simplepass.login');
        });

        Route::get('simplepass/logout', function (Request $request) {
            $this->logout($request);

            return redirect()->route('simplepass.login')->withCookies(Cookie::getQueuedCookies());
        });
    }
}
