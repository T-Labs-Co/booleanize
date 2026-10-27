<?php

declare(strict_types=1);

use TLabsCo\Booleanize\Booleanize;
use TLabsCo\Booleanize\Exceptions\InvalidValueBooleanizeException;

beforeEach(function () {
    $this->booleanize = new Booleanize;
});

it('converts yes to true', function () {
    expect($this->booleanize->convert('yes'))->toBeTrue();
});

it('converts no to false', function () {
    expect($this->booleanize->convert('no'))->toBeFalse();
});

it('converts y to true', function () {
    expect($this->booleanize->convert('y'))->toBeTrue();
});

it('converts n to false', function () {
    expect($this->booleanize->convert('n'))->toBeFalse();
});

it('converts on to true', function () {
    expect($this->booleanize->convert('on'))->toBeTrue();
});

it('converts off to false', function () {
    expect($this->booleanize->convert('off'))->toBeFalse();
});

it('converts enable to true', function () {
    expect($this->booleanize->convert('enable'))->toBeTrue();
});

it('converts disable to false', function () {
    expect($this->booleanize->convert('disable'))->toBeFalse();
});

it('converts 1 to true', function () {
    expect($this->booleanize->convert('1'))->toBeTrue();
});

it('converts 0 to false', function () {
    expect($this->booleanize->convert('0'))->toBeFalse();
});

it('converts integer 1 to true', function () {
    expect($this->booleanize->convert(1))->toBeTrue();
});

it('converts integer 0 to false', function () {
    expect($this->booleanize->convert(0))->toBeFalse();
});

it('converts boolean true to true', function () {
    expect($this->booleanize->convert(true))->toBeTrue();
});

it('converts boolean false to false', function () {
    expect($this->booleanize->convert(false))->toBeFalse();
});

it('converts case insensitive values', function () {
    expect($this->booleanize->convert('YES'))->toBeTrue();
    expect($this->booleanize->convert('Yes'))->toBeTrue();
    expect($this->booleanize->convert('NO'))->toBeFalse();
});

it('converts with custom true value', function () {
    expect($this->booleanize->convert('yes', null, 'y'))->toBe('y');
    expect($this->booleanize->convert('no', null, 'y'))->toBe('n');
});

it('returns default when value not found', function () {
    expect($this->booleanize->convert('yes', 'default', 'enable'))->toBe('enable');
});

it('converts array of values', function () {
    $result = $this->booleanize->convertArray(['yes', 'no', 'on']);
    expect($result)->toBe([true, false, true]);
});

it('returns inverse value', function () {
    expect($this->booleanize->inverse('yes'))->toBeFalse();
    expect($this->booleanize->inverse('no'))->toBeTrue();
});

it('returns human readable value for true', function () {
    $result = $this->booleanize->human('yes');
    expect($result)->toBeString();
});

it('returns human readable value for false', function () {
    $result = $this->booleanize->human('no');
    expect($result)->toBeString();
});

it('returns couple for mapped value', function () {
    $couple = $this->booleanize->couple('yes');
    expect($couple)->toBe(['yes' => 'no']);
});

it('returns null couple for unmapped value', function () {
    expect($this->booleanize->couple('unknown'))->toBeNull();
});

it('throws exception for invalid value with default config', function () {
    expect(fn () => $this->booleanize->isValid('invalid_value'))
        ->toThrow(InvalidValueBooleanizeException::class);
});

it('checks isTrue correctly', function () {
    expect($this->booleanize->isTrue('yes'))->toBeTrue();
    expect($this->booleanize->isTrue('no'))->toBeFalse();
});

it('checks isFalse correctly', function () {
    expect($this->booleanize->isFalse('no'))->toBeTrue();
    expect($this->booleanize->isFalse('yes'))->toBeFalse();
});

it('returns default true value', function () {
    expect($this->booleanize->defaultTrue())->toBeTrue();
});

it('returns default false value', function () {
    expect($this->booleanize->defaultFalse())->toBeFalse();
});

it('returns truthy values list', function () {
    $values = $this->booleanize->valuesTrue();
    expect($values)->toBeArray();
    expect($values)->toContain('yes', 'y', 'on', '1', 'true');
});

it('returns falsy values list', function () {
    $values = $this->booleanize->valuesFalse();
    expect($values)->toBeArray();
    expect($values)->toContain('no', 'n', 'off', '0', 'false');
});

it('allows chaining with config', function () {
    $result = $this->booleanize->withConfig(['default' => ['true' => 'enabled']]);
    expect($result)->toBeInstanceOf(Booleanize::class);
});
