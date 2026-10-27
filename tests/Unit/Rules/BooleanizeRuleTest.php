<?php

declare(strict_types=1);

use TLabsCo\Booleanize\Rules\BooleanizeRule;

it('passes validation for valid booleanize value', function () {
    $rule = new BooleanizeRule;
    $failCalled = false;

    $rule->validate('field', 'yes', function () use (&$failCalled) {
        $failCalled = true;
    });

    expect($failCalled)->toBeFalse();
});

it('fails validation for invalid value', function () {
    $rule = new BooleanizeRule;
    $failCalled = false;

    $rule->validate('field', 'invalid_value', function () use (&$failCalled) {
        $failCalled = true;
    });

    expect($failCalled)->toBeTrue();
});

it('returns error message', function () {
    $rule = new BooleanizeRule;
    $message = $rule->message();

    expect($message)->toBeString();
    expect($message)->toContain('booleanize');
});
