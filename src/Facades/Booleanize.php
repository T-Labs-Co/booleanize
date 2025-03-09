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

/**
 * @method static \TLabsCo\Booleanize\Booleanize withConfig(array $options)
 * @method static string|bool convert($value, $default = null, $trueValue = null)
 * @method static string|bool convertArray($value, $default = null, $trueValue = null)
 * @method static string|bool inverse($value, $default = null, $trueValue = null)
 * @method static bool isValid($value)
 * @method static bool isTrue($value)
 * @method static bool isFalse($value)
 * @method static string human($value)
 * @method static array couple($value)
 * @method static string|bool defaultTrue()
 * @method static string|bool defaultFalse()
 *
 * @see \TLabsCo\Booleanize\Booleanize
 *
 * @thow \TLabsCo\Booleanize\Exceptions\InvalidTypeSupportBooleanizeException
 * @thow \TLabsCo\Booleanize\Exceptions\InvalidValueBooleanizeException
 * @thow \TLabsCo\Booleanize\Exceptions\NotFoundValueBooleanizeException
 */
class Booleanize extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'booleanize';
    }
}
