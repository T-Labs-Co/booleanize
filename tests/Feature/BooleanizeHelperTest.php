<?php

declare(strict_types=1);

use TLabsCo\Booleanize\Booleanize;

it('returns booleanize instance when called without arguments', function () {
    $result = booleanize();
    expect($result)->toBeInstanceOf(Booleanize::class);
});

it('converts scalar value using helper', function () {
    $result = booleanize('yes');
    expect($result)->toBeTrue();
});

it('converts array of values using helper', function () {
    $result = booleanize(['status' => 'yes', 'active' => 'no']);
    expect($result)->toBe(['status' => true, 'active' => false]);
});
