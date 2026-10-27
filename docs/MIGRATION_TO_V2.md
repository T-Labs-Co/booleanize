# Migration Guide: v1.x → v2.0

This guide helps you upgrade `t-labs-co/booleanize` from version 1.x to version 2.0.

## Summary of Breaking Changes

| Change | v1.x | v2.0 |
|--------|------|------|
| PHP version | `^8.2\|^8.3\|^8.4` | `^8.4` |
| Laravel version | `^11.0\|^12.0` | `^12.0\|^13.0` |
| `HasBooleanizeTrait` namespace | `TLabsCo\Booleanize\HasBooleanizeTrait` | `TLabsCo\Booleanize\Model\HasBooleanizeTrait` |
| Service provider | `TLabsCo\Booleanize\BooleanizeServiceProvider` | `TLabsCo\Booleanize\Providers\BooleanizeServiceProvider` |
| Helper functions file | `src/helpers.php` | `src/Support/functions.php` |
| `spatie/laravel-package-tools` | Dependency used | Removed, native provider |
| `BooleanizeCommand` | Stub command exists | Removed |

---

## Step 1: Upgrade PHP and Laravel

Before upgrading the package, ensure your project meets the new requirements:

- **PHP 8.4 or higher**
- **Laravel 12 or 13**

```bash
php -v  # Check PHP version
php artisan --version  # Check Laravel version
```

---

## Step 2: Update Composer

```bash
composer require t-labs-co/booleanize:^2.0
```

---

## Step 3: Update Namespace Imports

### HasBooleanizeTrait: Root → `Model\`

The `HasBooleanizeTrait` has been moved from the root namespace to the `Model` namespace.

```diff
- use TLabsCo\Booleanize\HasBooleanizeTrait;
+ use TLabsCo\Booleanize\Model\HasBooleanizeTrait;
```

### Service Provider: Root → `Providers\`

If you manually registered the service provider (e.g., in a non-Laravel auto-discovery setup), update the class name:

```diff
- TLabsCo\Booleanize\BooleanizeServiceProvider::class
+ TLabsCo\Booleanize\Providers\BooleanizeServiceProvider::class
```

If you rely on Laravel's auto-discovery (the `"extra.laravel.providers"` key in `composer.json`), no action is needed — the provider will be discovered automatically.

### Other Unchanged Namespaces

These namespaces remain the same:

- `TLabsCo\Booleanize\Booleanize`
- `TLabsCo\Booleanize\Facades\Booleanize`
- `TLabsCo\Booleanize\Casts\BooleanizeCast`
- `TLabsCo\Booleanize\Casts\BooleanizeInboundCast`
- `TLabsCo\Booleanize\Rules\BooleanizeRule`
- `TLabsCo\Booleanize\Rules\BooleanizeTrueRule`
- `TLabsCo\Booleanize\Rules\BooleanizeFalseRule`
- `TLabsCo\Booleanize\Exceptions\InvalidTypeSupportBooleanizeException`
- `TLabsCo\Booleanize\Exceptions\InvalidValueBooleanizeException`
- `TLabsCo\Booleanize\Exceptions\NotFoundValueBooleanizeException`

---

## Step 4: Helper Functions

The `booleanize()` helper function is still auto-loaded via Composer, but the source file has moved from `src/helpers.php` to `src/Support/functions.php`.

**No code changes are needed** — the function is loaded through the `autoload.files` configuration in `composer.json`. The function signature remains the same:

```php
booleanize($value = null, $default = null, $trueValue = null)
```

---

## Step 5: Removed Components

The following components have been removed in v2.0. If you were using them, you'll need to find alternatives:

| Removed | Reason | Alternative |
|---------|--------|-------------|
| `BooleanizeCommand` Artisan command | Stub command with no functionality | N/A |
| `spatie/laravel-package-tools` | Unnecessary dependency | Native service provider |
| `database/` directory | Not part of library scope | N/A |
| `resources/` directory | Not needed | N/A |

---

## Full Before/After Example

### Before (v1.x)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\Booleanize\HasBooleanizeTrait;
use TLabsCo\Booleanize\Casts\BooleanizeCast;

class User extends Model
{
    use HasBooleanizeTrait;

    protected $casts = [
        'is_active' => BooleanizeCast::class,
    ];

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
```

### After (v2.0)

```php
<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\Booleanize\Model\HasBooleanizeTrait;
use TLabsCo\Booleanize\Casts\BooleanizeCast;

class User extends Model
{
    use HasBooleanizeTrait;

    protected $casts = [
        'is_active' => BooleanizeCast::class,
    ];

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
```

---

## Bug Fixes That Affect Behavior

### `isValid()` Control Flow

The `isValid()` method now uses explicit `if/throw` instead of `throw_if()`. The behavior is the same, but the method now always returns a `bool` type explicitly, with proper type casting on the fallback path.

### `stdClass` Empty Object Comparison

The check for empty objects now uses `(array) $value === []` instead of `$value == new \stdClass`. This provides a more reliable comparison for detecting empty objects.

### Validation Rules Exception Handling

All validation rules (`BooleanizeRule`, `BooleanizeTrueRule`, `BooleanizeFalseRule`) now catch `\Throwable` instead of `\Exception`, ensuring that errors and fatal exceptions are also properly handled during validation.

### Casts `method_exists()` Guards

`BooleanizeCast` and `BooleanizeInboundCast` now check `method_exists()` before calling trait-specific methods like `getTrueValueAs()` and `setTrueValueAs()`. This prevents errors when the trait is used but the required methods are not defined on the model.

### Query Scopes Fix

The `scopeWhereBooleanizeTrue()` and `scopeWhereBooleanizeFalse()` methods in `HasBooleanizeTrait` were previously broken, using `self::` instead of `$builder->`. They now correctly use the builder instance to apply query constraints.

---

## Quick Search & Replace Reference

Use these search patterns to find all occurrences in your codebase:

```bash
# HasBooleanizeTrait namespace change
grep -r "TLabsCo\\\\Booleanize\\\\HasBooleanizeTrait" app/

# Old service provider (if manually registered)
grep -r "TLabsCo\\\\Booleanize\\\\BooleanizeServiceProvider" app/ config/
```
