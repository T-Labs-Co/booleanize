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

namespace TLabsCo\Booleanize\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Usage:
 * ```php
 * // it may be No, N, false
 * $request->validate([
        'term_confirm' => ['required', new BooleanizeFalseRule],
    ]);
 * ```
 */
class BooleanizeFalseRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check booleanize
        try {
            if (! booleanize()->isValid($value) || ! booleanize()->isFalse($value)) {
                $fail($this->message());
            }
        } catch (\Exception $e) {
            $fail($this->message());
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a booleanize False value. Maybe: '
            .implode(',', array_unique(booleanize()->valuesFalse()));
    }
}
