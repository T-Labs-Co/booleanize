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

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use TLabsCo\Booleanize\Exceptions\InvalidTypeSupportBooleanizeException;
use TLabsCo\Booleanize\Exceptions\InvalidValueBooleanizeException;

final class Booleanize
{
    private $config = [];

    public function __construct($options = [])
    {
        $this->config = array_merge_recursive(config('booleanize'), $options);
    }

    public function withConfig($options)
    {
        $this->config = array_merge_recursive($this->config, $options);

        return $this;
    }

    public function convert($value, $default = null, $trueValue = null)
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
            return array_key_first($couple);
        }

        if ($couple && $this->isFalse($value)) {
            return $couple[array_key_first($couple)];
        }

        return $default;
    }

    public function convertArray($values, $default = null, $trueValue = null)
    {
        $convertValues = [];

        foreach ($values as $key => $value) {
            $convertValues[$key] = $this->convert($value, $default, $trueValue);
        }

        return $convertValues;
    }

    public function inverse($value, $default = null, $trueValue = null)
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
            return array_key_first($couple);
        }

        if ($couple && $this->isTrue($value)) {
            return $couple[array_key_first($couple)];
        }

        // not found
        return $default;
    }

    public function isValid($value)
    {
        if ($this->isTrue($value) || $this->isFalse($value)) {
            return true;
        }

        throw_if($this->otherAsException(), new InvalidValueBooleanizeException);

        return $this->otherAs();
    }

    public function isTrue($value)
    {
        $this->canConvert($value, true);

        $value = $this->clean($value);

        if ($value === null) {
            return $this->nullAs();
        }

        if (is_object($value) && $value == new \stdClass) {
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

    public function isFalse($value)
    {
        $this->canConvert($value, true);

        $value = $this->clean($value);

        if ($value === null && $this->nullAs() === false) {
            return true;
        }

        if (is_object($value) && $value == new \stdClass && $this->objectEmptyAs() === false) {
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

    public function human($value)
    {
        if ($this->isTrue($value)) {
            return Arr::random($this->valuesHuman()['true']);
        }

        if ($this->isFalse($value)) {
            return Arr::random($this->valuesHuman()['false']);
        }

        return Arr::random($this->valuesHuman()['unknown']);
    }

    private function fixCouple($value)
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

    public function couple($value)
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

    private function canConvert($value, $throwUnsupportException = false)
    {
        $type = gettype($value);

        if (! in_array($type, $this->allowTypes(), true)) {
            throw_if($throwUnsupportException, new InvalidTypeSupportBooleanizeException);

            return false;
        }

        return true;
    }

    private function clean(mixed $value): mixed
    {
        $this->canConvert($value, true);

        return is_string($value) ? Str::lower(Str::trim($value)) : $value;
    }

    public function defaultTrue()
    {
        return Arr::get($this->config, 'default.true');
    }

    public function defaultFalse()
    {
        return Arr::get($this->config, 'default.false');
    }

    private function valuesTrue()
    {
        return Arr::get($this->config, 'values.true');
    }

    private function valuesFalse()
    {
        return Arr::get($this->config, 'values.false');
    }

    private function valuesMap()
    {
        return Arr::get($this->config, 'values.map');
    }

    private function valuesHuman()
    {
        return Arr::get($this->config, 'values.human');
    }

    private function allowTypes()
    {
        return Arr::get($this->config, 'types.allow');
    }

    private function nullAs()
    {
        return Arr::get($this->config, 'types.null_as');
    }

    private function objectAs()
    {
        return Arr::get($this->config, 'types.object_as');
    }

    private function objectEmptyAs()
    {
        return Arr::get($this->config, 'types.object_empty_as');
    }

    private function arrayAs()
    {
        return Arr::get($this->config, 'types.array_as');
    }

    private function arrayEmptyAs()
    {
        return Arr::get($this->config, 'types.array_empty_as');
    }

    private function otherAs()
    {
        return Arr::get($this->config, 'types.other_as');
    }

    private function otherAsException()
    {
        return Arr::get($this->config, 'types.other_as') === 'exception';
    }
}
