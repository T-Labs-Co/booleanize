<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use TLabsCo\Booleanize\Casts\BooleanizeCast;
use TLabsCo\Booleanize\Model\HasBooleanizeTrait;

class TestModelWithTrait extends Model
{
    use HasBooleanizeTrait;
}

class TestModelWithoutTrait extends Model {}

it('casts value using get method without trait', function () {
    $model = new TestModelWithoutTrait;
    $cast = new BooleanizeCast;

    $result = $cast->get($model, 'status', 'yes', []);
    expect($result)->toBeTrue();
});

it('casts value using set method without trait', function () {
    $model = new TestModelWithoutTrait;
    $cast = new BooleanizeCast;

    $result = $cast->set($model, 'status', 'no', []);
    expect($result)->toBeFalse();
});

it('casts value using get method with trait', function () {
    $model = new TestModelWithTrait;
    $cast = new BooleanizeCast;

    $result = $cast->get($model, 'status', 'on', []);
    expect($result)->toBeTrue();
});

it('casts value using set method with trait', function () {
    $model = new TestModelWithTrait;
    $cast = new BooleanizeCast;

    $result = $cast->set($model, 'status', 'off', []);
    expect($result)->toBeFalse();
});
