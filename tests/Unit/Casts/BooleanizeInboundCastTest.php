<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use TLabsCo\Booleanize\Casts\BooleanizeInboundCast;
use TLabsCo\Booleanize\Model\HasBooleanizeTrait;

class InboundTestModelWithTrait extends Model
{
    use HasBooleanizeTrait;
}

class InboundTestModelWithoutTrait extends Model {}

it('casts inbound value without trait', function () {
    $model = new InboundTestModelWithoutTrait;
    $cast = new BooleanizeInboundCast;

    $result = $cast->set($model, 'status', 'yes', []);
    expect($result)->toBeTrue();
});

it('casts inbound value with trait', function () {
    $model = new InboundTestModelWithTrait;
    $cast = new BooleanizeInboundCast;

    $result = $cast->set($model, 'status', 'no', []);
    expect($result)->toBeFalse();
});
