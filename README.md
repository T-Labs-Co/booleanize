# Helper to work with Boolean in less pain

[![Latest Version on Packagist](https://img.shields.io/packagist/v/t-labs-co/booleanize.svg?style=flat-square)](https://packagist.org/packages/t-labs-co/booleanize)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/t-labs-co/booleanize/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/t-labs-co/booleanize/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/t-labs-co/booleanize/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/t-labs-co/booleanize/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/t-labs-co/booleanize.svg?style=flat-square)](https://packagist.org/packages/t-labs-co/booleanize)

This package helps you deal with **Boolean value** in your laravel project, support action **cast model attribute, check value is true/false, convert to your desire boolean form**. It's super handy for keeping things clean and avoiding copy-paste, so you can grab what you need quickly and cut down on extra coding.

## Work with us

We're PHP and Laravel whizzes, and we'd love to work with you! We can:

- Design the perfect fit solution for your app.
- Make your code cleaner and faster.
- Refactoring and Optimize performance.
- Ensure Laravel best practices are followed.
- Provide expert Laravel support.
- Review code and Quality Assurance.
- Offer team and project leadership.
- Delivery Manager

## PHP and Laravel Version Support

This package supports the following versions of PHP and Laravel:

- PHP: `^8.2`
- Laravel: `^11.0`, `^12.0`

## Installation

You can install the package via composer:

```bash
composer require t-labs-co/booleanize
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="booleanize-config"
```

This is the contents of the published config file:

```php
return [
// Override your configuration 
];
```

## Feature 

- Check input value is `true` or `false` 
- Convert input value to desired Boolean form 
- Cast model attribute to correct value 

## Usage

#### Convert to bool with helper

```php
// use helper class 
booleanize('true', null, true); // OUTPUT: true

// or call instance and using
booleanize()->convert('Yes', null, true); // OUTPUT: true 
booleanize()->convert('Yes', null, 1); // OUTPUT: 1 

booleanize()->convert('No', null, true); // OUTPUT: false 
booleanize()->convert('No', null, 1); // OUTPUT: 0 
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [T.Labs & Co.](https://github.com/ty-huynh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
