<?php

declare(strict_types=1);

use TLabsCo\Booleanize\Booleanize;

it('registers the booleanize service', function () {
    expect(app('booleanize'))->toBeInstanceOf(Booleanize::class);
});

it('registers booleanize as singleton', function () {
    $first = app('booleanize');
    $second = app('booleanize');

    expect($first)->toBe($second);
});

it('merges config from package', function () {
    $this->assertTrue(config()->has('booleanize'));
    expect(config('booleanize.default.true'))->toBeTrue();
});

it('loads the service provider', function () {
    expect(app('booleanize'))->toBeInstanceOf(Booleanize::class);
    expect(config('booleanize.default.true'))->toBeTrue();
});
