<?php

declare(strict_types=1);

namespace TPG\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use TPG\Simple\ServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function defineRoutes($router)
    {
        $router->get('/', function () {
            return 'logged in';
        });
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('simplepass.enabled', true);
        $app['config']->set('simplepass.secret', '$2y$10$jLOBQdxWtjyn6epJFZSLJe7RJtYwzAi8/DxpntbghRW/LPc//JkzG');   //password
    }
}
