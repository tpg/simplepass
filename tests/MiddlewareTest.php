<?php

declare(strict_types=1);

namespace TPG\Tests;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use TPG\Simple\Contracts\SimplePassInterface;
use TPG\Simple\SimplePassMiddleware;

class MiddlewareTest extends TestCase
{
    /**
     * @test
     **/
    public function it_will_redirect_to_login_when_not_authenticated(): void
    {
        $request = Request::create(url('/'));

        $middleware = new SimplePassMiddleware(app(SimplePassInterface::class));

        /**
         * @var RedirectResponse $response
         */
        $response = $middleware->handle($request, function () {
        });

        $this->assertTrue($response->isRedirect(url('simplepass/auth')));
    }

    /**
     * @test
     **/
    public function simeple_test(): void
    {
        $response = $this->withMiddleware(SimplePassMiddleware::class)->withCookie('simple-pass-auth', config('simplepass.secret'))->get('/');
    }
}
