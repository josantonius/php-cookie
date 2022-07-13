# CHANGELOG

## [2.0.2](https://github.com/josantonius/php-cookie/releases/tag/2.0.2) (2022-07-13)

* Fixed required PHP version.

* Improved documentation.

## [2.0.1](https://github.com/josantonius/php-cookie/releases/tag/2.0.1) (2022-07-13)

* Removed `phpDocumentor` for generate documentation.

* Added documentation for available methods.

* Renamed the facade from `Josantonius\Cookie\CookieFacade` to `Josantonius\Cookie\Facades\Cookie`.

## [2.0.0](https://github.com/josantonius/php-cookie/releases/tag/2.0.0) (2022-07-12)

**IMPORTANT:**

> Version 1.x is considered as deprecated and unsupported.
> In this version (2.x) the library was completely restructured.
> It is recommended to review the documentation for this version and make the necessary changes
> before starting to use it, as it not be compatible with version 1.x.

---

* The library was completely refactored.

* Support for PHP version 8.1.

* Support for earlier versions of PHP **8.1** is discontinued.

* Replaced all static methods in `Josantonius\Cookie\Cookie` class.

  A facade class was added to access the methods statically: `Josantonius\Cookie\CookieFacade`.

* Improved documentation; `README.md`, `CODE_OF_CONDUCT.md`, `CONTRIBUTING.md` and `CHANGELOG.md`.

* Removed `Codacy`.

* Removed `PHP Coding Standards Fixer`.

* The `master` branch was renamed to `main`.

* The `develop` branch was added to use a workflow based on `Git Flow`.

* `Travis` is discontinued for continuous integration. `GitHub Actions` will be used from now on.

* Added `phpDocumentor` for generate documentation.

* Added `.github/CODE_OF_CONDUCT.md` file.
* Added `.github/CONTRIBUTING.md` file.
* Added `.github/FUNDING.yml` file.
* Added `.github/workflows/ci.yml` file.
* Added `.github/lang/es-ES/CODE_OF_CONDUCT.md` file.
* Added `.github/lang/es-ES/CONTRIBUTING.md` file.
* Added `.github/lang/es-ES/LICENSE` file.
* Added `.github/lang/es-ES/README` file.

* Deleted `.travis.yml` file.
* Deleted `.editorconfig` file.
* Deleted `CONDUCT.MD` file.
* Deleted `README-ES.MD` file.
* Deleted `.php_cs.dist` file.

## [1.1.6](https://github.com/josantonius/php-cookie/releases/tag/1.1.6) (2018-01-05)

* The tests were fixed.

* Changes in documentation.

## [1.1.5](https://github.com/josantonius/php-cookie/releases/tag/1.1.5) (2017-11-08)

* Implemented `PHP Mess Detector` to detect inconsistencies in code styles.

* Implemented `PHP Code Beautifier and Fixer` to fixing errors automatically.

* Implemented `PHP Coding Standards Fixer` to organize PHP code automatically according to PSR standards.

* Added `Josantonius\Cookie\Cookie::getCookiePrefix()` method.

## [1.1.4](https://github.com/josantonius/php-cookie/releases/tag/1.1.4) (2017-10-25)

* Implemented `PSR-4 autoloader standard` from all library files.

* Implemented `PSR-2 coding standard` from all library PHP files.

* Implemented `PHPCS` to ensure that PHP code complies with `PSR2` code standards.

* Implemented `Codacy` to automates code reviews and monitors code quality over time.

* Implemented `Codecov` to coverage reports.

* Added `Cookie/phpcs.ruleset.xml` file.

* Deleted `Cookie/src/bootstrap.php` file.

* Deleted `Cookie/tests/bootstrap.php` file.

* Deleted `Cookie/vendor` folder.

* Changed `Josantonius\Cookie\Test\CookieTest` class to  `Josantonius\Cookie\CookieTest` class.

## [1.1.3](https://github.com/josantonius/php-cookie/releases/tag/1.1.3) (2017-09-11)

* Unit tests supported by `PHPUnit` were added.

* The repository was synchronized with Travis CI to implement continuous integration.

* Added `Cookie/src/bootstrap.php` file

* Added `Cookie/tests/bootstrap.php` file.

* Added `Cookie/phpunit.xml.dist` file.
* Added `Cookie/_config.yml` file.
* Added `Cookie/.travis.yml` file.

* Deleted `Josantonius\Cookie\Cookie::display()` method.

* Deleted `Josantonius\Cookie\Tests\CookieTest` class.
* Deleted `Josantonius\Cookie\Tests\CookieTest::testSetCookie()` method.
* Deleted `Josantonius\Cookie\Tests\CookieTest::testPullCookie()` method.
* Deleted `Josantonius\Cookie\Tests\CookieTest::testGetCookie()` method.
* Deleted `Josantonius\Cookie\Tests\CookieTest::testDisplayCookies()` method.
* Deleted `Josantonius\Cookie\Tests\CookieTest::testDestroyOneCookie()` method.
* Deleted `Josantonius\Cookie\Tests\CookieTest::testDestroyAllCookies()` method.

* Added `Josantonius\Cookie\Test\CookieTest` class.
* Added `Josantonius\Cookie\Test\CookieTest::testSetCookie()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testPullCookie()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testPullCookieNonExistent()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testGetCookie()` method.
* Added `Josantonius\Cookie\Tests\CookieTest::testGetAllCookiesNonExistents()()` method.
* Added `Josantonius\Cookie\Tests\CookieTest::testGetAllCookiesNonExistents()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testDisplayCookies()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testDestroyOneCookie()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testDestroyOneCookieNonExistent()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testDestroyAllCookies()` method.
* Added `Josantonius\Cookie\Test\CookieTest::testDestroyAllCookiesNonExistents()` method.

## [1.1.2](https://github.com/josantonius/php-cookie/releases/tag/1.1.2) (2017-07-16)

* Deleted `Josantonius\Cookie\Exception\CookieException` class.
* Deleted `Josantonius\Cookie\Exception\Exceptions` abstract class.
* Deleted `Josantonius\Cookie\Exception\CookieException->__construct()` method.

## [1.1.1](https://github.com/josantonius/php-cookie/releases/tag/1.1.1) (2017-03-18)

* Some files were excluded from download and comments and readme files were updated.

## [1.1.0](https://github.com/josantonius/php-cookie/releases/tag/1.1.0) (2017-01-30)

* Compatible with PHP 5.6 or higher.

## [1.0.0](https://github.com/josantonius/php-cookie/releases/tag/1.0.0) (2016-12-15)

* Compatible only with PHP 7.0 or higher. In the next versions, the library will be modified to make it compatible with PHP 5.6 or higher.

* Added `Josantonius\Cookie\Cookie` class.
* Added `Josantonius\Cookie\Cookie::set()` method.
* Added `Josantonius\Cookie\Cookie::pull()` method.
* Added `Josantonius\Cookie\Cookie::get()` method.
* Added `Josantonius\Cookie\Cookie::display()` method.
* Added `Josantonius\Cookie\Cookie::destroy()` method.

* Added `Josantonius\Cookie\Exception\CookieException` class.
* Added `Josantonius\Cookie\Exception\Exceptions` abstract class.
* Added `Josantonius\Cookie\Exception\CookieException->__construct()` method.

* Added `Josantonius\Cookie\Tests\CookieTest` class.
* Added `Josantonius\Cookie\Tests\CookieTest::testSetCookie()` method.
* Added `Josantonius\Cookie\Tests\CookieTest::testPullCookie()` method.
* Added `Josantonius\Cookie\Tests\CookieTest::testGetCookie()` method.
* Added `Josantonius\Cookie\Tests\CookieTest::testDisplayCookies()` method.
* Added `Josantonius\Cookie\Tests\CookieTest::testDestroyOneCookie()` method.
* Added `Josantonius\Cookie\Tests\CookieTest::testDestroyAllCookies()` method.
