<?php

/*
 * This file is a part of package t-co-labs/booleanize
 *
 * (c) T.Labs & Co.
 * Contact for Work: T. <hongty.huynh@gmail.com>
 *
 * We're PHP and Laravel whizzes, and we'd love to work with you! We can:
 *  - Design the perfect fit solution for your app.
 *  - Make your code cleaner and faster.
 *  - Refactoring and Optimize performance.
 *  - Ensure Laravel best practices are followed.
 *  - Provide expert Laravel support.
 *  - Review code and Quality Assurance.
 *  - Offer team and project leadership.
 *  - Delivery Manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TLabsCo\Booleanize;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TLabsCo\Booleanize\Commands\BooleanizeCommand;

class BooleanizeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('booleanize')
            ->hasConfigFile()
            ->hasCommand(BooleanizeCommand::class);
    }

    public function packageRegistered()
    {
        $this->app->singleton('booleanize', function () {
            return new Booleanize;
        });
    }

    public function packageBooted()
    {
        // Override config

    }
}
