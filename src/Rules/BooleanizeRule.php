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

namespace TLabsCo\Booleanize\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Usage:
 * ```php
 * // it may be Y, Yes, No, N, true, false
 * $request->validate([
        'term_confirm' => ['required', new BooleanizeRule],
    ]);
 * ```
 */
class BooleanizeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check booleanize
        try {
            if (! booleanize()->isValid($value)) {
                $fail($this->message());
            }
        } catch (\Throwable $e) {
            $fail($this->message());
        }
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must be a booleanize value. Maybe: '
            .implode(',', array_unique(booleanize()->valuesTrue())).' as True. '
            .implode(',', array_unique(booleanize()->valuesFalse())).' as False.';
    }
}
