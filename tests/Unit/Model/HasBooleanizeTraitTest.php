<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TLabsCo\Booleanize\Model\HasBooleanizeTrait;

class ScopeTestModel extends Model
{
    use HasBooleanizeTrait;

    protected $table = 'test_models';
}

it('provides whereBooleanize scope with null', function () {
    $model = new ScopeTestModel;
    $builder = Mockery::mock(Builder::class, [
        Mockery::mock(Illuminate\Database\Query\Builder::class),
    ]);

    $builder->shouldReceive('whereNull')
        ->once()
        ->with('status')
        ->andReturnSelf();

    $result = $model->scopeWhereBooleanize($builder, 'status', null);
    expect($result)->not->toBeNull();
});

it('provides whereBooleanizeTrue scope', function () {
    $model = new ScopeTestModel;
    $builder = Mockery::mock(Builder::class, [
        Mockery::mock(Illuminate\Database\Query\Builder::class),
    ]);

    $builder->shouldReceive('whereBooleanize')
        ->once()
        ->with('status', true)
        ->andReturnSelf();

    $result = $model->scopeWhereBooleanizeTrue($builder, 'status');
    expect($result)->not->toBeNull();
});

it('provides whereBooleanizeFalse scope', function () {
    $model = new ScopeTestModel;
    $builder = Mockery::mock(Builder::class, [
        Mockery::mock(Illuminate\Database\Query\Builder::class),
    ]);

    $builder->shouldReceive('whereBooleanize')
        ->once()
        ->with('status', false)
        ->andReturnSelf();

    $result = $model->scopeWhereBooleanizeFalse($builder, 'status');
    expect($result)->not->toBeNull();
});

it('provides whereBooleanize scope with value', function () {
    $model = new ScopeTestModel;
    $builder = Mockery::mock(Builder::class, [
        Mockery::mock(Illuminate\Database\Query\Builder::class),
    ]);

    $builder->shouldReceive('where')
        ->once()
        ->andReturnSelf();

    $result = $model->scopeWhereBooleanize($builder, 'status', 'yes');
    expect($result)->not->toBeNull();
});
