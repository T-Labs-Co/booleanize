<?php

declare(strict_types=1);

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

namespace TLabsCo\Booleanize\Providers;

use Illuminate\Support\ServiceProvider;
use TLabsCo\Booleanize\Booleanize;

class BooleanizeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/booleanize.php',
            'booleanize'
        );

        $this->app->singleton('booleanize', function () {
            return new Booleanize;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/booleanize.php' => config_path('booleanize.php'),
        ], 'booleanize-config');
    }
}
