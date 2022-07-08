# PHP Cookie library

PHP library for handling cookies, based on the excellent library from Josantonius:
https://github.com/josantonius/PHP-Cookie

Basically it's a fork with modifications for PHP 8 upwards (union types ecc.), transforming the static methods to normal ones and real-time updates of the $_COOKIE array.

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

This library is supported by **PHP versions 8.0 ** or higher.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **PHP Cookie library**, simply:

$ composer require pixxel/cookie

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

$ composer require pixxel/cookie --prefer-source
You can also **clone the complete repository** with Git:

$ git clone https://github.com/pixxelfactory/cookie.git
Or **install it manually**:

[Download Cookie.php](https://raw.githubusercontent.com/pixxelfactory/cookie/master/src/Cookie.php):

$ wget https://raw.githubusercontent.com/pixxelfactory/cookie/master/src/Cookie.php
## Available Methods

Available methods in this library:

### - Set cookie:

```php
$cookie->set($key, $value, $time);
```

| Attribute | Description              | Type   | Required | Default |
| ----------- | -------------------------- | -------- | ---------- | --------- |
| $key      | Cookie name.             | string | Yes      |         |
| $value    | The data to save.        | string | Yes      |         |
| $time     | Expiration time in days. | string | No       | 365     |

**# Return** (boolean)

### - Get item from cookie:

```php
$cookie->get($key);
```

| Attribute | Description  | Type   | Required | Default |
| ----------- | -------------- | -------- | ---------- | --------- |
| $key      | Cookie name. | string | No       | ''      |

**# Return** (mixed|false) → returns cookie value, cookies array or false

### - Extract item from cookie and delete cookie:

```php
$cookie->pull($key);
```

| Attribute | Description  | Type   | Required | Default |
| ----------- | -------------- | -------- | ---------- | --------- |
| $key      | Cookie name. | string | Yes      |         |

**# Return** (string|false) → item or false when key does not exists

### - Extract item from cookie and delete cookie:

```php
$cookie->destroy($key);
```

| Attribute | Description                                    | Type   | Required | Default |
| ----------- | ------------------------------------------------ | -------- | ---------- | --------- |
| $key      | Cookie name to destroy. Not set to delete all. | string | No       | ''      |

**# Return** (boolean)

### - Set cookie prefix:

```php
$cookie->setPrefix($prefix);
```

| Attribute | Description    | Type   | Required | Default |
| ----------- | ---------------- | -------- | ---------- | --------- |
| $prefix   | Cookie prefix. | string | Yes      |         |

**# Return** (boolean)

### - Get cookie prefix:

```php
$cookie->getPrefix();
```
**# Return** (string) → cookie prefix

## Quick Start

To use this class with **Composer**:

```php
require __DIR__ . '/vendor/autoload.php';

use Pixxel\Cookie;
```
Or If you installed it **manually**, use it:

```php
require_once __DIR__ . '/Cookie.php';

use Pixxel\Cookie;
```
## Usage

Example of use for this library:

### - Set cookie:

```php
$cookie->set('cookie_name', 'value', 365);
```
### - Get cookie:

```php
$cookie->get('cookie_name');
```
### - Get all cookies:

```php
$cookie->get();
```
### - Pull cookie:

```php
$cookie->pull('cookie_name');
```
### - Destroy one cookie:

```php
$cookie->destroy('cookie_name');
```
### - Destroy all cookies:

```php
$cookie->destroy();
```
### - Set cookie prefix:

```php
$cookie->setPrefix('prefix_');
```
### - Get cookie prefix:

```php
$cookie->getPrefix();
```
## Tests

To run [tests](tests) you just need [composer](http://getcomposer.org/download/) and to execute the following:

$ git clone https://github.com/pixxelfactory/cookie.git

$ cd PHP-Cookie

$ composer install
Run unit tests with [PHPUnit](https://phpunit.de/):

$ composer phpunit
Run [PSR2](http://www.php-fig.org/psr/psr-2/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

$ composer phpcs
Run [PHP Mess Detector](https://phpmd.org/) tests to detect inconsistencies in code style:

$ composer phpmd
Run all previous tests:

$ composer tests
## ☑ TODO

- [ ] Add new feature.
- [ ] Improve tests.
- [ ] Improve documentation.
- [ ] Refactor code for disabled code style rules. See [phpmd.xml](phpmd.xml) and [.php_cs.dist](.php_cs.dist).

## License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

## Copyright

The original copyright:
2016 - 2018 Josantonius, [josantonius.com](https://josantonius.com/)