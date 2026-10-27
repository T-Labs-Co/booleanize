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

namespace TLabsCo\Booleanize;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use TLabsCo\Booleanize\Exceptions\InvalidTypeSupportBooleanizeException;
use TLabsCo\Booleanize\Exceptions\InvalidValueBooleanizeException;

final class Booleanize
{
    /** @var array<string, mixed> */
    private array $config = [];

    /**
     * @param  array<string, mixed>  $options
     */
    public function __construct(array $options = [])
    {
        $this->config = array_merge_recursive(config('booleanize'), $options);
    }

    /**
     * @param  array<string, mixed>  $options
     */
    public function withConfig(array $options): self
    {
        $this->config = array_merge_recursive($this->config, $options);

        return $this;
    }

    public function convert(mixed $value, mixed $default = null, mixed $trueValue = null): mixed
    {
        $this->canConvert($value, true);

        $this->isValid($value);

        $value = $this->clean($value);

        $couple = $this->couple($trueValue ?? $this->defaultTrue());

        if ($this->fixCouple($trueValue) && is_numeric($trueValue) && $this->isTrue($value)) {
            // fix value
            return 1;
        }
        if ($this->fixCouple($trueValue) && is_bool($trueValue) && $this->isTrue($value)) {
            // fix value
            return true;
        }
        if ($this->fixCouple($trueValue) && is_numeric($trueValue) && $this->isFalse($value)) {
            // fix value
            return 0;
        }
        if ($this->fixCouple($trueValue) && is_bool($trueValue) && $this->isFalse($value)) {
            // fix value
            return false;
        }

        if ($couple && $this->isTrue($value)) {
            // Handle PHP boolean key coercion: [true => false] becomes [1 => false]
            if (array_key_first($couple) === 1 && $couple[1] === false) {
                return true;
            }

            return array_key_first($couple);
        }

        if ($couple && $this->isFalse($value)) {
            // Handle PHP boolean key coercion: [true => false] becomes [1 => false]
            if (array_key_first($couple) === 1 && $couple[1] === false) {
                return false;
            }

            return $couple[array_key_first($couple)];
        }

        return $default;
    }

    /**
     * @param  array<string, mixed>  $values
     * @return array<string, mixed>
     */
    public function convertArray(array $values, mixed $default = null, mixed $trueValue = null): array
    {
        $convertValues = [];

        foreach ($values as $key => $value) {
            $convertValues[$key] = $this->convert($value, $default, $trueValue);
        }

        return $convertValues;
    }

    public function inverse(mixed $value, mixed $default = null, mixed $trueValue = null): mixed
    {
        $this->canConvert($value, true);

        $this->isValid($value);

        $value = $this->clean($value);

        $couple = $this->couple($trueValue ?? $this->defaultTrue());

        if ($this->fixCouple($trueValue) && is_numeric($trueValue) && $this->isTrue($value)) {
            // fix value
            return 0;
        }
        if ($this->fixCouple($trueValue) && is_bool($trueValue) && $this->isTrue($value)) {
            // fix value
            return false;
        }
        if ($this->fixCouple($trueValue) && is_numeric($trueValue) && $this->isFalse($value)) {
            // fix value
            return 1;
        }
        if ($this->fixCouple($trueValue) && is_bool($trueValue) && $this->isFalse($value)) {
            // fix value
            return true;
        }

        if ($couple && $this->isFalse($value)) {
            // Handle PHP boolean key coercion: [true => false] becomes [1 => false]
            if (array_key_first($couple) === 1 && $couple[1] === false) {
                return true;
            }

            return array_key_first($couple);
        }

        if ($couple && $this->isTrue($value)) {
            // Handle PHP boolean key coercion: [true => false] becomes [1 => false]
            if (array_key_first($couple) === 1 && $couple[1] === false) {
                return false;
            }

            return $couple[array_key_first($couple)];
        }

        // not found
        return $default;
    }

    public function isValid(mixed $value): bool
    {
        if ($this->isTrue($value) || $this->isFalse($value)) {
            return true;
        }

        if ($this->otherAsException()) {
            throw new InvalidValueBooleanizeException;
        }

        return (bool) $this->otherAs();
    }

    public function isTrue(mixed $value): bool
    {
        $this->canConvert($value, true);

        $value = $this->clean($value);

        if ($value === null) {
            return $this->nullAs();
        }

        if (is_object($value) && (array) $value === []) {
            return $this->objectEmptyAs();
        }

        if (is_object($value)) {
            return $this->objectAs();
        }

        if (is_array($value) && empty($value)) {
            return $this->arrayEmptyAs();
        }

        if (is_array($value)) {
            return $this->arrayAs();
        }

        return in_array($value, $this->valuesTrue(), true);
    }

    public function isFalse(mixed $value): bool
    {
        $this->canConvert($value, true);

        $value = $this->clean($value);

        if ($value === null && $this->nullAs() === false) {
            return true;
        }

        if (is_object($value) && (array) $value === [] && $this->objectEmptyAs() === false) {
            return true;
        }

        if (is_object($value) && $this->objectAs() === false) {
            return true;
        }

        if (is_array($value) && empty($value) && $this->arrayEmptyAs() === false) {
            return true;
        }

        if (is_array($value) && $this->arrayAs() === false) {
            return true;
        }

        return in_array($value, $this->valuesFalse(), true);
    }

    public function human(mixed $value): string
    {
        if ($this->isTrue($value)) {
            return Arr::random($this->valuesHuman()['true']);
        }

        if ($this->isFalse($value)) {
            return Arr::random($this->valuesHuman()['false']);
        }

        return Arr::random($this->valuesHuman()['unknown']);
    }

    /**
     * @return array<int, bool>|array<int, int>|null
     */
    private function fixCouple(mixed $value): ?array
    {
        if ($value === true || $value === false) {
            return [true => false];
        }
        if ($value === 1 || $value === 0) {
            return [1 => 0];
        }
        if ($value === '1' || $value === '0') {
            return [1 => 0];
        }

        return null;
    }

    /**
     * @return array<int|string, bool|string|int>|null
     */
    public function couple(mixed $value): ?array
    {
        $value = $this->clean($value);

        $fixCouple = $this->fixCouple($value);

        if ($fixCouple) {
            return $fixCouple;
        }

        foreach ($this->valuesMap() as $couple) {
            if (array_key_first($couple) === $value || $couple[array_key_first($couple)] === $value) {
                return $couple;
            }
        }

        return null;
    }

    private function canConvert(mixed $value, bool $throwUnsupportException = false): bool
    {
        $type = gettype($value);

        if (! in_array($type, $this->allowTypes(), true)) {
            if ($throwUnsupportException) {
                throw new InvalidTypeSupportBooleanizeException;
            }

            return false;
        }

        return true;
    }

    private function clean(mixed $value): mixed
    {
        $this->canConvert($value, true);

        return is_string($value) ? Str::lower(Str::trim($value)) : $value;
    }

    public function defaultTrue(): mixed
    {
        return Arr::get($this->config, 'default.true');
    }

    public function defaultFalse(): mixed
    {
        return Arr::get($this->config, 'default.false');
    }

    /**
     * @return array<int, mixed>
     */
    public function valuesTrue(): array
    {
        return Arr::get($this->config, 'values.true');
    }

    /**
     * @return array<int, mixed>
     */
    public function valuesFalse(): array
    {
        return Arr::get($this->config, 'values.false');
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function valuesMap(): array
    {
        return Arr::get($this->config, 'values.map');
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function valuesHuman(): array
    {
        return Arr::get($this->config, 'values.human');
    }

    /**
     * @return array<int, string>
     */
    private function allowTypes(): array
    {
        return Arr::get($this->config, 'types.allow');
    }

    private function nullAs(): bool
    {
        return Arr::get($this->config, 'types.null_as');
    }

    private function objectAs(): bool
    {
        return Arr::get($this->config, 'types.object_as');
    }

    private function objectEmptyAs(): bool
    {
        return Arr::get($this->config, 'types.object_empty_as');
    }

    private function arrayAs(): bool
    {
        return Arr::get($this->config, 'types.array_as');
    }

    private function arrayEmptyAs(): bool
    {
        return Arr::get($this->config, 'types.array_empty_as');
    }

    private function otherAs(): mixed
    {
        return Arr::get($this->config, 'types.other_as');
    }

    private function otherAsException(): bool
    {
        return Arr::get($this->config, 'types.other_as') === 'exception';
    }
}
