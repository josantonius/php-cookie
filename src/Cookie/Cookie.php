<?php
/**
 * PHP library for handling cookies.
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2016 - 2017
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link       https://github.com/Josantonius/PHP-Cookie
 * @since      1.0.0
 */

namespace Josantonius\Cookie;

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
    public static $_prefix = 'jst_';

    /**
     * Set cookie.
     *
     * @since 1.0.0
     *
     * @param string $key   → name the data to save
     * @param string $value → the data to save
     * @param string $time  → expiration time in days
     *
     * @return boolean
     */
    public static function set($key, $value, $time = 365) {

        $prefix = self::$_prefix . $key;

        return setcookie($prefix, $value, time() + (86400 * $time), '/');
    }

    /**
     * Get item from cookie.
     *
     * @since 1.0.0
     *
     * @param string $key → item to look for in cookie
     *
     * @return string|null → returns key value, or null if key doesn't exists
     */
    public static function get($key) {

        $cookieName = self::$_prefix . $key;

        return isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : null;
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @since 1.0.0
     *
     * @param string $key → item to extract
     *
     * @return string|false → return item or false when key does not exists
     */
    public static function pull($key) {

        if (isset($_COOKIE[self::$_prefix . $key])) {

            setcookie(self::$_prefix.$key, '', time() - 3600, '/');

            return $_COOKIE[self::$_prefix . $key];
        }

        return false;
    }

    /**
     * Empties and destroys the cookies.
     *
     * @since 1.0.0
     *
     * @param string $key → cookie name to destroy. Not set to delete all
     *
     * @return boolean
     */
    public static function destroy($key = '') {

        if (isset($_COOKIE[self::$_prefix . $key])) { 

            setcookie(self::$_prefix . $key, '', time() - 3600, '/'); 

            return true;
        }

        if (count($_COOKIE) > 0) {

            foreach ($_COOKIE as $key => $value) {
                    
                setcookie($key, '', time() - 3600, '/');
            }
        
            return true;
        }

        return false;
    }

    /**
     * Return cookies array.
     *
     * @since 1.0.0
     *
     * @return array|null → of cookie indexes
     */
    public static function display() {

        return isset($_COOKIE) ? $_COOKIE : null;

    }
}
