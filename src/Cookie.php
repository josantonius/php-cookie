<?php
/**
 * PHP library for handling cookies.
 * Removed all the static stuff, i prefer instances and DI for handling values and libraries globally
 * I modified it so that the set values will be reflected in the $_COOKIE array in real time and not on page refresh, which solves a lot of problems (especially with authentication).
 * Also i simplified the namespace, since i tend to keep the main libraries on our main namespace
 * 
 * @link      https://github.com/pixxelfactory/cookie
 * Forked and modified by Pixxelfactory, based on the work from:
 *
 * @author    Josantonius <hello@josantonius.com>: https://github.com/Josantonius/PHP-Cookie
 * @copyright 2016 - 2018 (c) Josantonius - PHP-Cookie
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @since     1.0.0
 */
namespace Pixxel;

/**
 * Cookie handler.
 *
 * @since 1.0.0
 */
class Cookie
{
    /**
     * Prefix for cookies.
     *
     * @var string
     */
    public string $prefix = 'pixx_';

    /**
     * Set cookie.
     *
     * @param string $key   → name the data to save
     * @param string $value → the data to save
     * @param string $time  → expiration time in days
     *
     * @return boolean
     */
    public function set(string $key, string $value, int $time = 365): bool
    {
        $key = $this->prefix . $key;

        if (setcookie($key, $value, time() + (86400 * $time), '/')) {
            $_COOKIE[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * Get item from cookie.
     *
     * @param string $key → item to look for in cookie
     *
     * @return mixed|false → returns cookie value, cookies array or false
     */
    public function get($key = false): mixed
    {
        // If no key is set, return the whole cookie
        if ($key === false)
        {
            return $_COOKIE;
        }

        // If the key is set and exists, return that
        if (isset($_COOKIE[$this->prefix . $key])) 
        {
            return $_COOKIE[$this->prefix . $key];
        }

        // Otherwise return false
        return false;
    }

    /**
     * Checks if a cookie exists
     * @param string $key
     */
    public function has(string $key): bool
    {
        return isset($_COOKIE[$this->prefix . $key]) ? true : false;
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @param string $key → item to extract
     *
     * @return string|false → return item or false when key does not exists
     */
    public function pull(string $key): string|bool
    {
        $key = $this->prefix . $key;

        if (isset($_COOKIE[$key])) {
            setcookie($key, '', time() - 3600, '/');
            $ret = $_COOKIE[$key];
            unset($_COOKIE[$key]);

            return $ret;
        }

        return false;
    }

    /**
     * Empties and destroys the cookies.
     *
     * @param string $key → cookie name to destroy. Not set to delete all
     *
     * @return boolean
     */
    public function destroy($key = '')
    {
        $key = $this->prefix . $key;

        if (isset($_COOKIE[$key])) {
            setcookie($key, '', time() - 3600, '/');
            unset($_COOKIE[$key]);

            return true;
        }

        if (count($_COOKIE) > 0) {
            foreach ($_COOKIE as $key => $value) {
                setcookie($key, '', time() - 3600, '/');
                $_COOKIE[$key] = '';
            }

            return true;
        }

        return false;
    }

    /**
     * Set cookie prefix.
     *
     * @since 1.1.6
     *
     * @param string $prefix → cookie prefix
     *
     * @return boolean
     */
    public function setPrefix($prefix)
    {
        if (!empty($prefix) && is_string($prefix)) {
            $this->prefix = $prefix;
            return true;
        }

        return false;
    }

    /**
     * Get cookie prefix.
     *
     * @since 1.1.5
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}
