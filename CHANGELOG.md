# Changelog

All notable changes to `booleanize` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-10-26

### Breaking

- **Dropped PHP 8.2 and 8.3** — minimum PHP version is now `^8.4`
- **Dropped Laravel 11** — minimum Laravel version is now `^12|^13`
- **Removed `spatie/laravel-package-tools` dependency** — replaced with native service provider
- **Moved `HasBooleanizeTrait`** — namespace changed from `TLabsCo\Booleanize\` to `TLabsCo\Booleanize\Model\`
- **Moved service provider** — namespace changed to `TLabsCo\Booleanize\Providers\BooleanizeServiceProvider`
- **Removed `BooleanizeCommand`** — the stub command provided no useful functionality
- **`isValid()` throws explicitly** — replaced `throw_if()` with explicit `if/throw` control flow

### Added

- **Full strict types coverage** — `declare(strict_types=1)` on all source files
- **Complete parameter and return type hints** — all public and private methods are fully typed for PHPStan Level 8 compliance
- **Native service provider** — `BooleanizeServiceProvider` without Spatie dependency
- **DDD-aligned structure** — `Model/`, `Providers/`, `Support/` namespaces
- **`method_exists()` guards in casts** — `BooleanizeCast` and `BooleanizeInboundCast` safely check for trait methods before calling them
- **Comprehensive test suite** — 60+ tests covering core conversion, edge cases, casts, rules, model trait, helper, and service provider
- **Standardized CI/CD** — GitHub Actions workflows for tests (PHP 8.4/8.5 × Laravel 12/13) and static analysis
- **`pint.json`** — Laravel code style preset configuration
- **`AGENTS.md`** — agent guide documenting package architecture and development guidelines

### Changed

- **Helper function moved** — `src/helpers.php` → `src/Support/functions.php`
- **`stdClass` comparison fixed** — uses `(array) $value === []` instead of `$value == new \stdClass`
- **Rules catch `\Throwable`** — validation rules now catch `\Throwable` instead of `\Exception`
- **Facade `@method` annotations fixed** — all return types now correctly annotated
- **PHPStan upgraded to Level 8** — with Larastan extension, baseline removed
- **PHPUnit restructured** — schema 11.0, two test suites (Unit and Feature)
- **README rewritten** — updated badges, requirements, truthy/falsy tables, and examples

### Removed

- `src/Commands/BooleanizeCommand.php` — useless stub command
- `src/BooleanizeServiceProvider.php` (root-level Spatie provider)
- `database/` directory — not part of library scope
- `resources/` directory — not needed
- `build/` directory — CI artifacts only
- `phpstan-baseline.neon` — no longer needed with Level 8 compliance
- `phpstan.neon.dist` — consolidated into `phpstan.neon`
- Old CI workflows (`run-tests.yml`, `phpstan.yml`)

## [1.0.0] - 2025-03-18

### Added

- Initial release of the `booleanize` package.
- Support for converting various data types to boolean.
- Configuration options for customizing boolean conversion rules.
- Eloquent cast attributes for boolean types.
- Query scopes for model boolean attributes.
- Validation rules for request data with boolean types.
