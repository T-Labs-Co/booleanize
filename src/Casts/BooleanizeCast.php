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

namespace TLabsCo\Booleanize\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Arr;
use TLabsCo\Booleanize\Facades\Booleanize;

final class BooleanizeCast implements CastsAttributes
{
    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    private function hasUseBooleanize($model)
    {
        return in_array(HasBooleanizeCastTrait::class, class_uses_recursive(get_class($model)));
    }

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return bool|string
     */
    public function get($model, $key, $value, $attributes)
    {
        if ($this->hasUseBooleanize($model)) {
            $defaultTrue = Arr::get($model->getTrueValueAs(), $key, Booleanize::defaultTrue());
        } else {
            $defaultTrue = Booleanize::defaultTrue();
        }

        return Booleanize::convert($value, null, $defaultTrue);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return bool|string
     */
    public function set($model, $key, $value, $attributes)
    {
        if ($this->hasUseBooleanize($model)) {
            $defaultTrue = Arr::get($model->setTrueValueAs(), $key, Booleanize::defaultTrue());
        } else {
            $defaultTrue = Booleanize::defaultTrue();
        }

        return Booleanize::convert($value, null, $defaultTrue);
    }
}
