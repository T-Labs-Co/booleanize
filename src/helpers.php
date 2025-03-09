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

if (! function_exists('booleanize')) {
    /**
     * Get the booleanize instance or convert a value to a boolean.
     *
     * If an array is passed as the value, we will assume you want to convert an array of values.
     *
     * @param  array<string, mixed>|string|null  $value
     * @param  mixed  $default
     * @param  string|bool  $trueValue
     * @return \TLabsCo\Booleanize\Booleanize|mixed
     */
    function booleanize($value = null, $default = null, $trueValue = null)
    {
        if (is_array($value) && ! empty($value)) {
            return app('booleanize')->convertArray($value, $default, $trueValue);
        }

        if (! empty($value)) {
            return app('booleanize')->convert($value, $default, $trueValue);
        }

        return app('booleanize');
    }
}
