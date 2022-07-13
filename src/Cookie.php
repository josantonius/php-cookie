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

namespace Josantonius\Cookie;

use DateTime;
use Josantonius\Cookie\Exceptions\CookieException;
use Throwable;

/**
 * Cookie handler.
 */
class Cookie
{
    /**
     * Generates instance with a particular cookie settings configuration.
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
    public function __construct(
        private string $domain = '',
        private int|string|DateTime $expires = 0,
        private bool $httpOnly = false,
        private string $path = '/',
        private bool $raw = false,
        private null|string $sameSite = null,
        private bool $secure = false,
    ) {
        $this->failIfSameSiteValueIsWrong();

        set_error_handler(
            fn (int $severity, string $message, string $file) =>
            $file === __FILE__ && throw new CookieException($message)
        );
    }

    /**
     * Gets all cookies.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $_COOKIE ?? [];
    }

    /**
     * Checks if a cookie exists.
     */
    public function has(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Gets a cookie by name.
     *
     * Optionally defines a default value when the cookie does not exist.
     */
    public function get(string $name, mixed $default = null): mixed
    {
        return $_COOKIE[$name] ?? $default;
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
     * @throws CookieException if failure in date/time string analysis.
     */
    public function set(string $name, mixed $value, null|int|string|DateTime $expires = null): void
    {
        $params = [$name, $value, $this->getOptions($expires === null ? $this->expires : $expires)];

        $this->raw ? setrawcookie(...$params) : setcookie(...$params);
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
    public function replace(array $data, null|int|string|DateTime $expires = null): void
    {
        foreach ($data as $name => $value) {
            $this->set($name, $value, $expires);
        }
    }

    /**
     * Deletes a cookie by name and returns its value.
     *
     * Optionally defines a default value when the cookie does not exist.
     *
     * @throws CookieException if headers already sent.
     */
    public function pull(string $name, mixed $default = null): mixed
    {
        $value = $_COOKIE[$name] ?? $default;

        $this->remove($name);

        return $value;
    }

    /**
     * Deletes a cookie by name.
     *
     * @throws CookieException if headers already sent.
     * @throws CookieException if failure in date/time string analysis.
     */
    public function remove(string $name): void
    {
        $params = [$name, '', $this->getOptions(1, false)];

        $this->raw ? setrawcookie(...$params) : setcookie(...$params);
    }

    /**
     * Deletes all cookies.
     *
     * @throws CookieException if headers already sent.
     */
    public function clear(): void
    {
        foreach ($_COOKIE ?? [] as $name) {
            $this->remove($name);
        }
    }

    /**
     * Gets cookie options.
     *
     * @throws CookieException if failure in date/time string analysis.
     */
    private function getOptions(null|int|string|DateTime $expires, bool $formatTime = true): array
    {
        if ($formatTime) {
            $expires = $this->formatExpirationTime($expires);
        }

        $options = [
            'domain' => $this->domain,
            'expires' => $expires,
            'httponly' => $this->httpOnly,
            'path' => $this->path,
            'secure' => $this->secure,
        ];

        if ($this->sameSite !== null) {
            $options['samesite'] = $this->sameSite;
        }

        return $options;
    }

    /**
     * Format the expiration time.
     *
     * @throws CookieException if failure in date/time string analysis.
     */
    private function formatExpirationTime(int|string|DateTime $expires): int
    {
        if ($expires instanceof DateTime) {
            return (int) $expires->format('U');
        } elseif (is_int($expires)) {
            return $expires;
        } elseif (is_string($expires)) {
            try {
                return (int) (new DateTime($expires))->format('U');
            } catch (Throwable $exception) {
                throw new CookieException($exception->getMessage(), $exception);
            }
        }
    }

    /**
     * Throw exception if $sameSite value is wrong.
     *
     * @throws CookieException if $sameSite value is wrong.
     */
    private function failIfSameSiteValueIsWrong(): void
    {
        $values = ['none', 'lax', 'strict'];

        if ($this->sameSite && !in_array(strtolower($this->sameSite), $values)) {
            throw new CookieException(
                'Invalid value for the sameSite param. Available values: ' . implode('|', $values)
            );
        }
    }
}
