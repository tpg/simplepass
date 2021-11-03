<?php

declare(strict_types=1);

namespace TPG\Simple\Contracts;

use Illuminate\Http\Request;

interface SimplePassInterface
{
    public function attempt(Request $request): bool;

    public function check(Request $request): bool;

    public function logout(Request $request): void;

    public function enabled(): bool;

    public function bootRoutes(): void;
}
