# Booleanize

[![Tests](https://github.com/t-labs-co/booleanize/actions/workflows/tests.yml/badge.svg)](https://github.com/t-labs-co/booleanize/actions/workflows/tests.yml)
[![Static Analysis](https://github.com/t-labs-co/booleanize/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/t-labs-co/booleanize/actions/workflows/static-analysis.yml)
[![PHPStan Level 8](https://img.shields.io/badge/PHPStan-Level%208-brightgreen.svg)](https://phpstan.org/)

Tools for easier boolean manipulation in Laravel.

## Requirements

- PHP ^8.4
- Laravel ^12|^13

## Installation

```bash
composer require t-labs-co/booleanize
```

> **Upgrading from v1.x?** Read the [Migration Guide](https://github.com/T-Labs-Co/booleanize/blob/main/docs/MIGRATION_TO_V2.md) for a step-by-step upgrade path.


## Usage

### Basic Conversion

```php
use TLabsCo\Booleanize\Facades\Booleanize;

// Convert various values to boolean
Booleanize::convert('yes');   // true
Booleanize::convert('no');    // false
Booleanize::convert('on');    // true
Booleanize::convert('off');   // false
Booleanize::convert('1');     // true
Booleanize::convert('0');     // false
```

### Helper Function

```php
booleanize('yes');   // true
booleanize('no');    // false

// Convert arrays
booleanize(['status' => 'yes', 'active' => 'no']);
// ['status' => true, 'active' => false]
```

### Truthy Values

The following values are recognized as **true**:

| Value | Type |
|-------|------|
| `y` | string |
| `yes` | string |
| `active` | string |
| `enable` | string |
| `on` | string |
| `1` | string |
| `true` | string |
| `good` | string |
| `ok` | string |
| `1` | integer |
| `true` | boolean |

### Falsy Values

The following values are recognized as **false**:

| Value | Type |
|-------|------|
| `n` | string |
| `no` | string |
| `inactive` | string |
| `disable` | string |
| `off` | string |
| `0` | string |
| `false` | string |
| `bad` | string |
| `not_ok` | string |
| `0` | integer |
| `false` | boolean |

### Validation Rules

```php
use TLabsCo\Booleanize\Rules\BooleanizeRule;
use TLabsCo\Booleanize\Rules\BooleanizeTrueRule;
use TLabsCo\Booleanize\Rules\BooleanizeFalseRule;

$request->validate([
    'status' => ['required', new BooleanizeRule],
    'active' => ['required', new BooleanizeTrueRule],
    'deleted' => ['required', new BooleanizeFalseRule],
]);
```

### Eloquent Casts

```php
use TLabsCo\Booleanize\Casts\BooleanizeCast;
use TLabsCo\Booleanize\Casts\BooleanizeInboundCast;

class User extends Model
{
    protected $casts = [
        'is_active' => BooleanizeCast::class,
        'status' => BooleanizeInboundCast::class,
    ];
}
```

### Model Trait

```php
use TLabsCo\Booleanize\Model\HasBooleanizeTrait;

class User extends Model
{
    use HasBooleanizeTrait;

    public function getTrueValueAs(): array
    {
        return [
            'is_active' => 'enabled',
        ];
    }

    public function setTrueValueAs(): array
    {
        return [
            'is_active' => 'enabled',
        ];
    }
}

// Query scopes
User::whereBooleanizeTrue('is_active')->get();
User::whereBooleanizeFalse('is_active')->get();
User::whereBooleanize('is_active', 'enabled')->get();
```

### Custom Values

```php
Booleanize::convert('yes', null, 'enabled');  // 'enabled'
Booleanize::convert('no', null, 'enabled');   // 'disabled'
```

### Inverse Conversion

```php
Booleanize::inverse('yes');  // false
Booleanize::inverse('no');   // true
```

### Human Readable

```php
Booleanize::human('yes');  // 'Yes, I agree'
Booleanize::human('no');   // 'No, I don't'
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=booleanize-config
```

## Quality

```bash
composer test      # Run Pest tests
composer analyse   # Run PHPStan
composer format    # Run Laravel Pint
```

## Credits

- [Ty Huynh](https://tyhuynh.id.vn)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
