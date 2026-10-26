<?php

declare(strict_types=1);
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;
use Illuminate\Contracts\Validation\ValidationRule;

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

arch('it will follow PSR-4 autoloading')
    ->expect('TLabsCo\Booleanize')
    ->toUsePsr4('TLabsCo\\Booleanize\\', __DIR__.'/../src');

arch('all rules implement ValidationRule')
    ->expect('TLabsCo\Booleanize\Rules')
    ->toImplement(ValidationRule::class);

arch('all casts implement proper interfaces')
    ->expect('TLabsCo\Booleanize\Casts')
    ->toImplement([
        CastsAttributes::class,
        CastsInboundAttributes::class,
    ]);

arch('all exceptions extend Exception')
    ->expect('TLabsCo\Booleanize\Exceptions')
    ->toExtend(Exception::class);

arch('source files use strict types')
    ->expect('TLabsCo\Booleanize')
    ->in(__DIR__.'/../src')
    ->toUse('declare(strict_types=1)');
