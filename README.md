# SiGEs-Core

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ composer require jjsoft-ar/siges-core
```
**Add the template package to Laravel's service providers (config/app.php)**

*For <= 5.1*
``` php
JJSoft\SigesCore\Providers\SigesCoreServiceProvider::class,
```

*For > 5.1*
``` php
"JJSoft\SigesCore\Providers\SigesCoreServiceProvider",
```

**Run the below command to publish package files**

``` bash
php artisan vendor:publish --force
```
## Usage

``` bash
php artisan siges:install
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please tell us [https://github.com/jjsoft-ar/siges-core/issues][link-issues].

## Credits

- [José C Gallo][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jjsoft-ar/siges-core.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jjsoft-ar/siges-core/master.svg?style=flat-square
[ico-scrutinizer]: https://codeclimate.com/github/jjsoft-ar/siges-core/badges/coverage.svg
[ico-code-quality]: https://codeclimate.com/github/jjsoft-ar/siges-core/badges/gpa.svg
[ico-downloads]: https://img.shields.io/packagist/dt/jjsoft-ar/siges-core.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/jjsoft-ar/siges-core
[link-travis]: https://travis-ci.org/jjsoft-ar/siges-core
[link-scrutinizer]: https://codeclimate.com/github/jjsoft-ar/siges-core/coverage
[link-code-quality]: https://codeclimate.com/github/jjsoft-ar/siges-core
[link-downloads]: https://packagist.org/packages/jjsoft-ar/siges-core
[link-author]: https://github.com/aguaragazu
[link-contributors]: ../../contributors
[link-issues]: https://github.com/jjsoft-ar/siges-core/issues