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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait HasBooleanizeTrait
{
    public function getTrueValueAs(): array
    {
        // config your default true value for your attribute when GET
        return [];
    }

    public function setTrueValueAs(): array
    {
        // config your default true value for your attribute when SET
        return [];
    }

    /**
     * @param  Builder|\Illuminate\Database\Query\Builder  $builder
     * @param  string  $field
     * @param  mixed  $value
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWhereBooleanize($builder, $field, $value)
    {
        $defaultTrue = Arr::get($this->setTrueValueAs(), $field, booleanize()->defaultTrue());

        if ($value === null) {
            return $builder->whereNull($field);
        }

        return $builder->where($field, booleanize($value, null, $defaultTrue));
    }

    /**
     * @param  Builder|\Illuminate\Database\Query\Builder  $builder
     * @param  string  $field
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWhereBooleanizeTrue($builder, $field)
    {
        return self::whereBooleanize($field, true);
    }

    /**
     * @param  Builder|\Illuminate\Database\Query\Builder  $builder
     * @param  string  $field
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWhereBooleanizeFalse($builder, $field)
    {
        return self::whereBooleanize($field, false);
    }
}
