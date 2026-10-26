<?php

declare(strict_types=1);

use TLabsCo\Booleanize\Rules\BooleanizeTrueRule;

it('passes validation for truthy value', function () {
    $rule = new BooleanizeTrueRule;
    $failCalled = false;

    $rule->validate('field', 'yes', function () use (&$failCalled) {
        $failCalled = true;
    });

    expect($failCalled)->toBeFalse();
});

it('fails validation for falsy value', function () {
    $rule = new BooleanizeTrueRule;
    $failCalled = false;

    $rule->validate('field', 'no', function () use (&$failCalled) {
        $failCalled = true;
    });

    expect($failCalled)->toBeTrue();
});

it('fails validation for invalid value', function () {
    $rule = new BooleanizeTrueRule;
    $failCalled = false;

    $rule->validate('field', 'invalid_value', function () use (&$failCalled) {
        $failCalled = true;
    });

    expect($failCalled)->toBeTrue();
});
