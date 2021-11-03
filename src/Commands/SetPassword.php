<?php

declare(strict_types=1);

namespace TPG\Simple\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetPassword extends Command
{
    protected $signature = 'simple:password {password}';

    protected $description = 'Set a new simple password';

    public function handle(): int
    {
        $hash = Hash::make($this->argument('password'));

        $this->info('Hash: '.$hash);

        $password = 'base64:'.base64_encode($hash);

        $env = file_get_contents($this->laravel->environmentFilePath());
        preg_match($this->keyReplacementPattern(), $env, $matches);

        if (! count($matches)) {
            $env .= PHP_EOL.'SIMPLE_SECRET=';
        }

        $set = preg_replace(
            $this->keyReplacementPattern(),
            'SIMPLE_SECRET='.$password,
            $env
        );

        file_put_contents($this->laravel->environmentFilePath(), $set);

        $this->info('Set new simple password.');

        return 0;
    }

    protected function keyReplacementPattern(): string
    {
        $escaped = preg_quote('='.config('simplepass.secret'), '/');

        return "/^SIMPLE_SECRET{$escaped}/m";
    }
}
