# AGENTS.md — Booleanize Package Guide

## Package Purpose

`t-labs-co/booleanize` provides tools for easier boolean manipulation in Laravel applications. It converts various string, integer, and boolean values to standardized boolean representations, with support for custom value mapping, validation rules, Eloquent casts, and model query scopes.

## Architecture

### DDD Structure

```
src/
├── Booleanize.php              # Core conversion logic
├── Casts/
│   ├── BooleanizeCast.php      # Eloquent attribute cast (get/set)
│   └── BooleanizeInboundCast.php  # Inbound cast (mass assignment)
├── Exceptions/
│   ├── InvalidTypeSupportBooleanizeException.php
│   ├── InvalidValueBooleanizeException.php
│   └── NotFoundValueBooleanizeException.php
├── Facades/
│   └── Booleanize.php          # Laravel facade
├── Model/
│   └── HasBooleanizeTrait.php  # Model trait with query scopes
├── Providers/
│   └── BooleanizeServiceProvider.php  # Native service provider
├── Rules/
│   ├── BooleanizeRule.php      # Validates any booleanize value
│   ├── BooleanizeTrueRule.php  # Validates truthy values
│   └── BooleanizeFalseRule.php # Validates falsy values
└── Support/
    └── functions.php           # booleanize() helper function
```

### Config Structure

`config/booleanize.php` defines:
- **default.true/false** — Default output values (default: `true`/`false`)
- **values.true/false** — Arrays of recognized truthy/falsy values
- **values.map** — Coupled value pairs (e.g., `['yes' => 'no']`)
- **values.human** — Human-readable output strings
- **types.allow** — Allowed input types
- **types.null_as, object_as, array_as, etc.** — Type handling behavior

### Key Components

1. **Booleanize** — Main class handling all conversion logic. Registered as a singleton in the service container under the `booleanize` key.

2. **Casts** — `BooleanizeCast` for bidirectional Eloquent casting, `BooleanizeInboundCast` for mass assignment. Both check for `HasBooleanizeTrait` on the model to use custom values.

3. **Rules** — Three validation rules: `BooleanizeRule` (any valid value), `BooleanizeTrueRule` (truthy only), `BooleanizeFalseRule` (falsy only).

4. **HasBooleanizeTrait** — Provides query scopes (`whereBooleanize`, `whereBooleanizeTrue`, `whereBooleanizeFalse`) and customizable value methods (`getTrueValueAs`, `setTrueValueAs`).

5. **Helper** — `booleanize()` function returns the instance when called without arguments, converts scalar values, or converts arrays.

## Testing Guidelines

- All source files must have `declare(strict_types=1)`.
- Tests are organized into `Unit/` and `Feature/` suites.
- Use Pest PHP for testing.
- Run tests with: `composer test`
- Run static analysis with: `composer analyse` (PHPStan Level 8)
- Format code with: `composer format` (Laravel Pint)

## Development Workflow

1. Make changes to source files in `src/`.
2. Ensure all files have `declare(strict_types=1)`.
3. Add or update tests in `tests/Unit/` or `tests/Feature/`.
4. Run `composer test` to verify tests pass.
5. Run `composer analyse` to verify PHPStan Level 8 passes.
6. Run `composer format` to ensure code style compliance.
