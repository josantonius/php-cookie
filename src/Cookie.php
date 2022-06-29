<?php
/**
 * PHP library for handling cookies.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2016 - 2018 (c) Josantonius - PHP-Cookie
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Cookie
 * @since     1.0.0
 */
namespace Josantonius\Cookie;

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
    public static $prefix = 'jst_';

    /**
     * Set cookie.
     *
     * @param string $key   → name the data to save
     * @param string $value → the data to save
     * @param string $time  → expiration time in days
     *
     * @return boolean
     */
    public static function set($key, $value, $time = 365)
    {
        $prefix = self::$prefix . $key;

        return setcookie($prefix, $value, time() + (86400 * $time), '/');
    }

    /**
     * Get item from cookie.
     *
     * @param string $key → item to look for in cookie
     *
     * @return mixed|false → returns cookie value, cookies array or false
     */
    public static function get($key = false)
    {
        // If no key is set, return the whole cookie
        if ($key === false)
        {
            return $_COOKIE;
        }

        // If the key is set and exists, return that
        if (isset($_COOKIE[self::$prefix . $key])) 
        {
            return $_COOKIE[self::$prefix . $key];
        }

        // Otherwise return false
        return false;
    }

    /**
     * Checks if a cookie exists
     * @param string $key
     */
    public static function has($key)
    {
        return isset($_COOKIE[self::$prefix . $key]) ? true : false;
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @param string $key → item to extract
     *
     * @return string|false → return item or false when key does not exists
     */
    public static function pull($key)
    {
        if (isset($_COOKIE[self::$prefix . $key])) 
        {
            setcookie(self::$prefix . $key, '', time() - 3600, '/');

            return $_COOKIE[self::$prefix . $key];
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
    public static function destroy($key = '')
    {
        if (isset($_COOKIE[self::$prefix . $key])) 
        {
            setcookie(self::$prefix . $key, '', time() - 3600, '/');

            return true;
        }

        if (count($_COOKIE) > 0) 
        {
            foreach ($_COOKIE as $key => $value) 
            {
                setcookie($key, '', time() - 3600, '/');
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
    public static function setPrefix($prefix)
    {
        if (!empty($prefix) && is_string($prefix)) 
        {
            self::$prefix = $prefix;
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
    public static function getPrefix()
    {
        return self::$prefix;
    }
}
