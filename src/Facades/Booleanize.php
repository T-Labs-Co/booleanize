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

namespace TLabsCo\Booleanize\Facades;

use Illuminate\Support\Facades\Facade;
use TLabsCo\Booleanize\Exceptions\InvalidTypeSupportBooleanizeException;
use TLabsCo\Booleanize\Exceptions\InvalidValueBooleanizeException;
use TLabsCo\Booleanize\Exceptions\NotFoundValueBooleanizeException;

/**
 * @method static \TLabsCo\Booleanize\Booleanize withConfig(array<string, mixed> $options)
 * @method static mixed convert(mixed $value, mixed $default = null, mixed $trueValue = null)
 * @method static array<string, mixed> convertArray(array<string, mixed> $values, mixed $default = null, mixed $trueValue = null)
 * @method static mixed inverse(mixed $value, mixed $default = null, mixed $trueValue = null)
 * @method static bool isValid(mixed $value)
 * @method static bool isTrue(mixed $value)
 * @method static bool isFalse(mixed $value)
 * @method static string human(mixed $value)
 * @method static array<int|string, bool|string|int>|null couple(mixed $value)
 * @method static mixed defaultTrue()
 * @method static mixed defaultFalse()
 *
 * @see \TLabsCo\Booleanize\Booleanize
 *
 * @throws InvalidTypeSupportBooleanizeException
 * @throws InvalidValueBooleanizeException
 * @throws NotFoundValueBooleanizeException
 */
class Booleanize extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'booleanize';
    }
}
