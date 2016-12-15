<?php 
/**
 * PHP library for handling cookies.
 * 
 * @category   JST
 * @package    Cookie
 * @subpackage CookieTest
 * @author     Josantonius - info@josantonius.com
 * @copyright  Copyright (c) 2016 JST PHP Framework
 * @license    https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @version    1.0.0
 * @link       https://github.com/Josantonius/PHP-Cookie
 * @since      File available since 1.0.0 - Update: 2016-12-15
 */

namespace Josantonius\Cookie\Tests;

use Josantonius\Cookie\Cookie;

/**
 * Tests class for Cookie library.
 *
 * @since 1.0.0
 */
class CookieTest { 

    /**
     * Set cookie.
     */
    public static function testSetCookie() {

        Cookie::set('CookieName', 'value', 365);
    }

    /**
     * Extract item from cookie then delete from the cookie and return the item.
     *
     * @return mixed|null → return item or null when key does not exists
     */
    public static function testPullCookie() {

        return Cookie::pull('CookieName');
    }

    /**
     * Get item from cookie.
     *
     * @return mixed|null → returns the key value, or null if key doesn't exists
     */
    public static function testGetCookie($key) {

        return Cookie::get('CookieName');
    }


    /**
     * Return cookies array.
     *
     * @return array|null → of cookie indexes
     */
    public static function testDisplayCookies() {

        return Cookie::display();
    }


    /**
     * Destroy one cookie.
     */
    public static function testDestroyOneCookie() {

        Cookie::destroy('CookieName');
    }

    /**
     * Destroy all cookies.
     */
    public static function testDestroyAllCookies() {

        Cookie::destroy();
    }
}
