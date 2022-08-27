# PHP Cookie library

[![Latest Stable Version](https://poser.pugx.org/josantonius/cookie/v/stable)](https://packagist.org/packages/josantonius/cookie)
[![License](https://poser.pugx.org/josantonius/cookie/license)](LICENSE)
[![Total Downloads](https://poser.pugx.org/josantonius/cookie/downloads)](https://packagist.org/packages/josantonius/cookie)
[![CI](https://github.com/josantonius/php-cookie/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/josantonius/php-cookie/actions/workflows/ci.yml)
[![CodeCov](https://codecov.io/gh/josantonius/php-cookie/branch/main/graph/badge.svg)](https://codecov.io/gh/josantonius/php-cookie)
[![PSR1](https://img.shields.io/badge/PSR-1-f57046.svg)](https://www.php-fig.org/psr/psr-1/)
[![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](https://www.php-fig.org/psr/psr-4/)
[![PSR12](https://img.shields.io/badge/PSR-12-1abc9c.svg)](https://www.php-fig.org/psr/psr-12/)

**Translations**: [Español](.github/lang/es-ES/README.md)

PHP library for handling cookies.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Available Classes](#available-classes)
  - [Cookie Class](#cookie-class)
  - [Cookie Facade](#cookie-facade)
- [Exceptions Used](#exceptions-used)
- [Usage](#usage)
- [About Cookie Expires](#about-cookie-expires)
- [Tests](#tests)
- [TODO](#todo)
- [Changelog](#changelog)
- [Contribution](#contribution)
- [Sponsor](#Sponsor)
- [License](#license)

---

## Requirements

This library is compatible with the PHP versions: 8.1.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **PHP Cookie library**, simply:

```console
composer require josantonius/cookie
```

The previous command will only install the necessary files,
if you prefer to **download the entire source code** you can use:

```console
composer require josantonius/cookie --prefer-source
```

You can also **clone the complete repository** with Git:

```console
git clone https://github.com/josantonius/php-cookie.git
```

## Available Classes

### Cookie Class

```php
use Josantonius\Cookie\Cookie;
```

Sets cookie options:

```php
/**
 * Cookie options:
 * 
 * domain:   Domain for which the cookie is available.
 * expires:  The time the cookie will expire.
 * httpOnly: If cookie will only be available through the HTTP protocol.
 * path:     Path for which the cookie is available.
 * raw:      If cookie will be sent as a raw string.
 * sameSite: Enforces the use of a Lax or Strict SameSite policy.
 * secure:   If cookie will only be available through the HTTPS protocol.
 * 
 * These settings will be used to create and delete cookies.
 * 
 * @throws CookieException if $sameSite value is wrong.
 *
 * @see https://www.php.net/manual/en/datetime.formats.php for date formats.
 * @see https://www.php.net/manual/en/function.setcookie.php for more information.
 */

public function __construct(
    private string              $domain   = '',
    private int|string|DateTime $expires  = 0,
    private bool                $httpOnly = false,
    private string              $path     = '/',
    private bool                $raw      = false,
    private null|string         $sameSite = null,
    private bool                $secure   = false
);
```

Sets a cookie by name:

```php
/**
 * @throws CookieException if headers already sent.
 * @throws CookieException if failure in date/time string analysis.
 */
public function set(
    string $name,
    mixed $value,
    null|int|string|DateTime $expires = null
): void;
```

Sets several cookies at once:

```php
/**
 * If cookies exist they are replaced, if they do not exist they are created.
 *
 * @throws CookieException if headers already sent.
 */
public function replace(
    array $data,
    null|int|string|DateTime $expires = null
): void;
```

Gets a cookie by name:

```php
/**
 * Optionally defines a default value when the cookie does not exist.
 */
public function get(string $name, mixed $default = null): mixed;
```

Gets all cookies:

```php
public function all(): array;
```

Check if a cookie exists:

```php
public function has(string $name): bool;
```

Deletes a cookie by name and returns its value:

```php
/**
 * Optionally defines a default value when the cookie does not exist.
 * 
 * @throws CookieException if headers already sent.
 */
public function pull(string $name, mixed $default = null): mixed;
```

Deletes an cookie by name:

```php
/**
 * @throws CookieException if headers already sent.
 * @throws CookieException if failure in date/time string analysis.
 */
public function remove(string $name): void;
```

### Cookie Facade

```php
use Josantonius\Cookie\Facades\Cookie;
```

Sets cookie options:

```php
/**
 * Cookie options:
 * 
 * domain:   Domain for which the cookie is available.
 * expires:  The time the cookie will expire.
 * httpOnly: If cookie will only be available through the HTTP protocol.
 * path:     Path for which the cookie is available.
 * raw:      If cookie will be sent as a raw string.
 * sameSite: Enforces the use of a Lax or Strict SameSite policy.
 * secure:   If cookie will only be available through the HTTPS protocol.
 * 
 * These settings will be used to create and delete cookies.
 * 
 * @throws CookieException if $sameSite value is wrong.
 *
 * @see https://www.php.net/manual/en/datetime.formats.php for date formats.
 * @see https://www.php.net/manual/en/function.setcookie.php for more information.
 */

public static function options(
    string              $domain   = '',
    int|string|DateTime $expires  = 0,
    bool                $httpOnly = false,
    string              $path     = '/',
    bool                $raw      = false,
    null|string         $sameSite = null,
    bool                $secure   = false
): void;
```

Sets a cookie by name:

```php
/**
 * @throws CookieException if headers already sent.
 * @throws CookieException if failure in date/time string analysis.
 */
public static function set(
    string $name,
    mixed $value,
    null|int|string|DateTime $expires = null
): void;
```

Sets several cookies at once:

```php
/**
 * If cookies exist they are replaced, if they do not exist they are created.
 *
 * @throws CookieException if headers already sent.
 */
public static function replace(
    array $data,
    null|int|string|DateTime $expires = null
): void;
```

Gets a cookie by name:

```php
/**
 * Optionally defines a default value when the cookie does not exist.
 */
public static function get(string $name, mixed $default = null): mixed;
```

Gets all cookies:

```php
public static function all(): array;
```

Check if a cookie exists:

```php
public static function has(string $name): bool;
```

Deletes a cookie by name and returns its value:

```php
/**
 * Optionally defines a default value when the cookie does not exist.
 * 
 * @throws CookieException if headers already sent.
 */
public static function pull(string $name, mixed $default = null): mixed;
```

Deletes an cookie by name:

```php
/**
 * @throws CookieException if headers already sent.
 * @throws CookieException if failure in date/time string analysis.
 */
public static function remove(string $name): void;
```

## Exceptions Used

```php
use Josantonius\Cookie\Exceptions\CookieException;
```

## Usage

Example of use for this library:

### Create Cookie instance with default options

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::options();
```

### Create Cookie instance with custom options

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie(
    domain: 'example.com',
    expires: time() + 3600,
    httpOnly: true,
    path: '/foo',
    raw: true,
    sameSite: 'Strict',
    secure: true,
);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::options(
    expires: 'now +1 hour',
    httpOnly: true,
);
```

### Sets a cookie by name

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->set('foo', 'bar');
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::set('foo', 'bar');
```

### Sets a cookie by name modifying the expiration time

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->set('foo', 'bar', time() + 3600);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::set('foo', 'bar', new DateTime('now +1 hour'));
```

### Sets several cookies at once

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->replace([
    'foo' => 'bar',
    'bar' => 'foo'
]);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::replace([
    'foo' => 'bar',
    'bar' => 'foo'
], time() + 3600);
```

### Sets several cookies at once modifying the expiration time

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->replace([
    'foo' => 'bar',
    'bar' => 'foo'
], time() + 3600);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::replace([
    'foo' => 'bar',
    'bar' => 'foo'
], time() + 3600);
```

### Gets a cookie by name

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->get('foo'); // null if the cookie does not exist
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::get('foo'); // null if the cookie does not exist
```

### Gets a cookie by name with default value if cookie does not exist

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->get('foo', false); // false if cookie does not exist
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::get('foo', false); // false if cookie does not exist
```

### Gets all cookies

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->all();
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::all();
```

### Check if a cookie exists

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->has('foo');
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::has('foo');
```

### Deletes a cookie by name and returns its value

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->pull('foo'); // null if attribute does not exist
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::pull('foo'); // null if attribute does not exist
```

### Deletes a cookie and returns its value or default value if does not exist

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->pull('foo', false); // false if attribute does not exist
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::pull('foo', false); // false if attribute does not exist
```

### Deletes an cookie by name

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->remove('foo');
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::remove('foo');
```

## About cookie expires

- The **expires** parameter used in several methods of this library accepts the following types:
`int|string|DateTime`.

  - `Integers` will be handled as unix time except zero.
  - `Strings` will be handled as date/time formats.
  See supported [Date and Time Formats](https://www.php.net/manual/en/datetime.formats.php)
  for more information.

    ```php
    $cookie = new Cookie(
        expires: '2016-12-15 +1 day'
    );
    ```

    It would be similar to:

    ```php
    $cookie = new Cookie(
        expires: new DateTime('2016-12-15 +1 day')
    );
    ```

  - `DateTime` objects will be used to obtain the unix time.

- If the **expires** parameter is used in the `set` or `replace` methods,
it will be taken instead of the **expires** value set in the cookie options.

    ```php
    $cookie = new Cookie(
        expires: 'now +1 minute'
    );

    $cookie->set('foo', 'bar');                        // Expires in 1 minute

    $cookie->set('bar', 'foo', 'now +8 days');         // Expires in 8 days

    $cookie->replace(['foo' => 'bar']);                // Expires in 1 minute

    $cookie->replace(['foo' => 'bar'], time() + 3600); // Expires in 1 hour
    ```

- If the **expires** parameter passed in the options is a date/time string,
it is formatted when using the `set` or `replace` method and not when setting the options.

    ```php
    $cookie = new Cookie(
        expires: 'now +1 minute', // It will not be formatted as unix time yet
    );

    $cookie->set('foo', 'bar');   // It is will formatted now and expires in 1 minute
    ```

## Tests

To run [tests](tests) you just need [composer](http://getcomposer.org/download/)
and to execute the following:

```console
git clone https://github.com/josantonius/php-cookie.git
```

```console
cd php-cookie
```

```console
composer install
```

Run unit tests with [PHPUnit](https://phpunit.de/):

```console
composer phpunit
```

Run code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

```console
composer phpcs
```

Run [PHP Mess Detector](https://phpmd.org/) tests to detect inconsistencies in code style:

```console
composer phpmd
```

Run all previous tests:

```console
composer tests
```

## TODO

- [ ] Add new feature
- [ ] Improve tests
- [ ] Improve documentation
- [ ] Improve English translation in the README file
- [ ] Refactor code for disabled code style rules (see phpmd.xml and phpcs.xml)

## Changelog

Detailed changes for each release are documented in the
[release notes](https://github.com/josantonius/php-cookie/releases).

## Contribution

Please make sure to read the [Contributing Guide](.github/CONTRIBUTING.md), before making a pull
request, start a discussion or report a issue.

Thanks to all [contributors](https://github.com/josantonius/php-cookie/graphs/contributors)! :heart:

## Sponsor

If this project helps you to reduce your development time,
[you can sponsor me](https://github.com/josantonius#sponsor) to support my open source work :blush:

## License

This repository is licensed under the [MIT License](LICENSE).

Copyright © 2016-present, [Josantonius](https://github.com/josantonius#contact)
