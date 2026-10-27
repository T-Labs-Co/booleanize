<?php

declare(strict_types=1);

namespace TLabsCo\Booleanize\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TLabsCo\Booleanize\Providers\BooleanizeServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BooleanizeServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
    }
}
