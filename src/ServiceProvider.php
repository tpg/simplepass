<?php

declare(strict_types=1);

namespace TPG\Simple;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TPG\Simple\Commands\SetPassword;
use TPG\Simple\Contracts\SimplePassInterface;

class ServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/simplepass.php', 'simplepass'
        );

        $this->app->bind(SimplePassInterface::class, SimplePass::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/simplepass.php' => config_path('simplepass.php'),
        ]);

        app('router')->prependMiddlewareToGroup('web', SimplePassMiddleware::class);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'simplepass');

        app(SimplePassInterface::class)->bootRoutes();

        if ($this->app->runningInConsole()) {
            $this->commands([
                SetPassword::class,
            ]);
        }
    }
}
