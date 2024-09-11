<?php

declare(strict_types=1);

/*
 * This file is part of https://github.com/josantonius/php-cookie repository.
 *
 * (c) Josantonius <hello@josantonius.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Josantonius\Cookie\Facades;

use Josantonius\Cookie\Cookie as CookieInstance;
use Josantonius\Cookie\Exceptions\CookieException;

/**
 * Cookie handler with static methods.
 */
class Cookie
{
    private static ?CookieInstance $cookie = null;

    private static function getInstance()
    {
        if (!self::$cookie) {
            self::options();
        }

        return self::$cookie;
    }

    /**
     * Set cookie options.
     *
     * These settings will be used to create and delete cookies.
     *
     * @param string              $domain   Domain for which the cookie is available.
     * @param int|string|DateTime $expires  The time the cookie will expire.
     *                                      Integers will be handled as unix time except zero.
     *                                      Strings will be handled as date/time formats.
     * @param bool                $httpOnly Access to cookie only through the HTTP protocol.
     * @param string              $path     Path where the cookie will be available.
     * @param bool                $raw      If cookie value should be sent without url encoding.
     * @param null|string         $sameSite Enforces the use of a Lax or Strict SameSite policy.
     *                                      Available values: None|Lax|Strict.
     * @param bool                $secure   Transmit cookie only over a secure HTTPS connection.
     *
     * @see https://www.php.net/manual/en/datetime.formats.php
     * @see https://www.php.net/manual/en/function.setcookie.php
     *
     * @throws CookieException if $sameSite value is wrong.
     */
    public static function options(
        string $domain = '',
        int|string|DateTime $expires = 0,
        bool $httpOnly = false,
        string $path = '/',
        bool $raw = false,
        null|string $sameSite = null,
        bool $secure = false,
    ): void {
        self::$cookie = new CookieInstance(
            domain: $domain,
            expires: $expires,
            httpOnly: $httpOnly,
            path: $path,
            raw: $raw,
            sameSite: $sameSite,
            secure: $secure,
        );
    }

    /**
     * Gets all cookies.
     */
    public static function all(): array
    {
        return self::getInstance()->all();
    }

    /**
     * Checks if a cookie exists.
     */
    public static function has(string $name): bool
    {
        return self::getInstance()->has($name);
    }

    /**
     * Gets a cookie by name.
     *
     * Optionally defines a default value when the cookie does not exist.
     */
    public static function get(string $name, mixed $default = null): mixed
    {
        return self::getInstance()->get($name, $default);
    }

    /**
     * Sets a cookie by name.
     *
     * @param null|int|string|DateTime $expires The time the cookie will expire.
     *                                          Integers will be handled as unix time except zero.
     *                                          Strings will be handled as date/time formats.
     *
     * @see https://www.php.net/manual/en/datetime.formats.php
     *
     * @throws CookieException if headers already sent.
     */
    public static function set(string $name, mixed $value, null|int|DateTime $expires = null): void
    {
        self::getInstance()->set($name, $value, $expires);
    }

    /**
     * Sets several cookies at once.
     *
     * If cookies exist they are replaced, if they do not exist they are created.
     *
     * @param array<string, mixed>     $data    An array of cookies.
     * @param null|int|string|DateTime $expires The time the cookie will expire.
     *                                          Integers will be handled as unix time except zero.
     *                                          Strings will be handled as date/time formats.
     *
     * @see https://www.php.net/manual/en/datetime.formats.php
     *
     * @throws CookieException if headers already sent.
     */
    public static function replace(array $data, null|int|DateTime $expires = null): void
    {
        self::getInstance()->replace($data, $expires);
    }

    /**
     * Deletes a cookie by name and returns its value.
     *
     * Optionally defines a default value when the cookie does not exist.
     *
     * @throws CookieException if headers already sent.
     */
    public static function pull(string $name, mixed $default = null): mixed
    {
        return self::getInstance()->pull($name, $default);
    }

    /**
     * Deletes a cookie by name.
     *
     * @throws CookieException if headers already sent.
     */
    public static function remove(string $name): void
    {
        self::getInstance()->remove($name);
    }

    /**
     * Deletes all cookies.
     *
     * @throws CookieException if headers already sent.
     */
    public static function clear(): void
    {
        self::getInstance()->clear();
    }
}
