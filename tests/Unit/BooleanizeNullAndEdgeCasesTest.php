<?php

declare(strict_types=1);

use TLabsCo\Booleanize\Booleanize;

beforeEach(function () {
    $this->booleanize = new Booleanize;
});

it('handles null value as false by default', function () {
    expect($this->booleanize->isTrue(null))->toBeFalse();
    expect($this->booleanize->isFalse(null))->toBeTrue();
});

it('handles empty array as false by default', function () {
    expect($this->booleanize->isTrue([]))->toBeFalse();
    expect($this->booleanize->isFalse([]))->toBeTrue();
});

it('handles non-empty array as true by default', function () {
    expect($this->booleanize->isTrue(['item']))->toBeTrue();
    expect($this->booleanize->isFalse(['item']))->toBeFalse();
});

it('handles empty object as false by default', function () {
    $obj = new stdClass;
    expect($this->booleanize->isTrue($obj))->toBeFalse();
    expect($this->booleanize->isFalse($obj))->toBeTrue();
});

it('handles non-empty object as true by default', function () {
    $obj = new stdClass;
    $obj->prop = 'value';
    expect($this->booleanize->isTrue($obj))->toBeTrue();
    expect($this->booleanize->isFalse($obj))->toBeFalse();
});
