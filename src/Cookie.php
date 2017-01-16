<?php declare(strict_types=1);
/**
 * PHP library for handling cookies.
 * 
 * @category   JST
 * @package    Cookie
 * @subpackage Cookie
 * @author     Josantonius - info@josantonius.com
 * @copyright  Copyright (c) 2016 JST PHP Framework
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @version    1.0.0
 * @link       https://github.com/Josantonius/PHP-Cookie
 * @since      File available since 1.0.0 - Update: 2016-12-19
 */

namespace Josantonius\Cookie;

# use Josantonius\Cookie\Exception\CookieException;

/**
 * Cookie handler.
 *
 * @since 1.0.0
 */
class Cookie { 

    /**
     * Prefix for cookies.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private static $_prefix = 'jst_';

    /**
     * Set cookie.
     *
     * @since 1.0.0
     *
     * @param string $key   → name the data to save
     * @param string $value → the data to save
     * @param string $time  → expiration time in days
     */
    public static function set(string $key, string $value, string $time = 365) {

        setcookie(self::$_prefix.$key, $value, time() + (86400 * $time), "/");
    }

    /**
     * Extract item from cookie then delete from the cookie and return the item.
     *
     * @since 1.0.0
     *
     * @param string $key → item to extract
     *
     * @return string|null → return item or null when key does not exists
     */
    public static function pull(string $key) {

        if (isset($_COOKIE[self::$_prefix . $key])) {

            setcookie(self::$_prefix.$key, "", time() - 3600, "/");

            return $_COOKIE[self::$_prefix . $key];
        }

        return null;
    }

    /**
     * Get item from cookie.
     *
     * @since 1.0.0
     *
     * @param string $key → item to look for in cookie
     *
     * @return string|null → returns the key value, or null if key doesn't exists
     */
    public static function get(string $key) {

        return $_COOKIE[self::$_prefix . $key] ?? null;
    }

    /**
     * Return cookies array.
     *
     * @since 1.0.0
     *
     * @return array|null → of cookie indexes
     */
    public static function display() {

        return $_COOKIE ?? null;

    }

    /**
     * Empties and destroys the cookies.
     *
     * @since 1.0.0
     *
     * @param string $key → cookie name to destroy. Not set to delete all
     */
    public static function destroy(string $key = '') {

        if (isset($_COOKIE[self::$_prefix . $key])) { 

            setcookie(self::$_prefix . $key, "", time() - 3600, "/"); 

            return;
        }

        if (count($_COOKIE) > 0) {

            foreach ($_COOKIE as $key => $value) {
                    
                setcookie($key, "", time() - 3600, "/");
            }
        }
    }
}