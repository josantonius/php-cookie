# PHP Cookie library

[![Latest Stable Version](https://poser.pugx.org/josantonius/Cookie/v/stable)](https://packagist.org/packages/josantonius/Cookie) [![Latest Unstable Version](https://poser.pugx.org/josantonius/Cookie/v/unstable)](https://packagist.org/packages/josantonius/Cookie) [![License](https://poser.pugx.org/josantonius/Cookie/license)](LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/e51e4c06b0b54ce493454d4f895a3ef3)](https://www.codacy.com/app/Josantonius/PHP-Cookie?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Josantonius/PHP-Cookie&amp;utm_campaign=Badge_Grade) [![Total Downloads](https://poser.pugx.org/josantonius/Cookie/downloads)](https://packagist.org/packages/josantonius/Cookie) [![Travis](https://travis-ci.org/Josantonius/PHP-Cookie.svg)](https://travis-ci.org/Josantonius/PHP-Cookie) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![CodeCov](https://codecov.io/gh/Josantonius/PHP-Cookie/branch/master/graph/badge.svg)](https://codecov.io/gh/Josantonius/PHP-Cookie)

[Versión en español](README-ES.md)

PHP library for handling cookies.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Available Methods](#available-methods)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [Tests](#tests)
- [TODO](#-todo)
- [Contribute](#contribute)
- [Repository](#repository)
- [License](#license)
- [Copyright](#copyright)

---

## Requirements

This library is supported by **PHP versions 5.6** or higher and is compatible with **HHVM versions 3.0** or higher.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **PHP Cookie library**, simply:

    $ composer require Josantonius/Cookie

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

    $ composer require Josantonius/Cookie --prefer-source

You can also **clone the complete repository** with Git:

	$ git clone https://github.com/Josantonius/PHP-Cookie.git

Or **install it manually**:

[Download Cookie.php](https://raw.githubusercontent.com/Josantonius/PHP-Cookie/master/src/Cookie.php):

    $ wget https://raw.githubusercontent.com/Josantonius/PHP-Cookie/master/src/Cookie.php

## Available Methods

Available methods in this library:

### - Set cookie:

```php
Cookie::set($key, $value, $time);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $key | Cookie name. | string | Yes | |
| $value | The data to save. | string | Yes | |
| $time | Expiration time in days. | string | No | 365 |

**# Return** (boolean)

### - Get item from cookie:

```php
Cookie::get($key);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $key | Cookie name. | string | No | '' |

**# Return** (mixed|false) → returns cookie value, cookies array or false

### - Extract item from cookie and delete cookie:

```php
Cookie::pull($key);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $key | Cookie name. | string | Yes | |

**# Return** (string|false) → item or false when key does not exists

### - Extract item from cookie and delete cookie:

```php
Cookie::destroy($key);
```

| Attribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $key | Cookie name to destroy. Not set to delete all. | string | No | '' |

**# Return** (boolean)

## Quick Start

To use this class with **Composer**:

```php
require __DIR__ . '/vendor/autoload.php';

use Josantonius\Cookie\Cookie;
```

Or If you installed it **manually**, use it:

```php
require_once __DIR__ . '/Cookie.php';

use Josantonius\Cookie\Cookie;
```

## Usage

Example of use for this library:

### - Set cookie:

```php
Cookie::set('cookie_name', 'value', 365);
```

### - Get cookie:

```php
Cookie::get('cookie_name');
```

### - Get all cookies:

```php
Cookie::get();
```

### - Pull cookie:

```php
Cookie::pull('cookie_name');
```

### - Destroy one cookie:

```php
Cookie::destroy('cookie_name');
```

### - Destroy all cookies:

```php
Cookie::destroy();
```

## Tests 

To run [tests](tests) you just need [Composer](http://getcomposer.org/download/) and to execute the following:

    $ git clone https://github.com/Josantonius/PHP-Cookie.git
    
    $ cd PHP-Cookie

    $ composer install

Run unit tests with [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Run [PSR2](http://www.php-fig.org/psr/psr-2/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Run all previous tests:

    $ composer tests

## ☑ TODO

- [x] Create tests
- [x] Improve documentation

## Contribute

1. Check for open issues or open a new issue to start a discussion around a bug or feature.
1. Fork the repository on GitHub to start making your changes.
1. Write one or more tests for the new feature or that expose the bug.
1. Make code changes to implement the feature or fix the bug.
1. Send a pull request to get your changes merged and published.

This is intended for large and long-lived objects.

## Repository

All files in this repository were created and uploaded automatically with [Reposgit Creator](https://github.com/Josantonius/BASH-Reposgit).

## License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

## Copyright

2016 - 2017 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).