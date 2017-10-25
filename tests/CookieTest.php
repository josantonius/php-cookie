<?php
/**
 * PHP library for handling cookies.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2016 - 2017 (c) Josantonius - PHP-Assets
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Cookie
 * @since     1.0.0
 */

namespace Josantonius\Cookie;

use PHPUnit\Framework\TestCase;

/**
 * Tests class for Cookie library.
 *
 * @since 1.1.3
 */
final class CookieTest extends TestCase
{
    /**
     * Set cookie.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testSetCookie()
    {
        $this->assertTrue(Cookie::set('cookie_name', 'value', 365));
    }

    /**
     * Get item from cookie.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testGetCookie()
    {
        $_COOKIE[Cookie::$prefix . 'cookie_name'] = 'value';

        $this->assertContains(Cookie::get('cookie_name'), 'value');
    }

    /**
     * Return cookies array.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testGetAllCookies()
    {
        $_COOKIE[Cookie::$prefix . 'cookie_name_one'] = 'value';
        $_COOKIE[Cookie::$prefix . 'cookie_name_two'] = 'value';

        $this->assertArrayHasKey(
            Cookie::$prefix . 'cookie_name_two',
            Cookie::get()
        );
    }

    /**
     * Return cookies array non-existent.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testGetAllCookiesNonExistents()
    {
        $this->assertFalse(Cookie::get());
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testPullCookie()
    {
        $_COOKIE[Cookie::$prefix . 'cookie_name'] = 'value';

        $this->assertContains(Cookie::pull('cookie_name'), 'value');
    }

    /**
     * Extract item from cookie non-existent.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testPullCookieNonExistent()
    {
        $this->assertFalse(Cookie::pull('cookie_name'));
    }

    /**
     * Destroy one cookie.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testDestroyOneCookie()
    {
        $_COOKIE[Cookie::$prefix . 'cookie_name'] = 'value';

        $this->assertTrue(Cookie::destroy('cookie_name'));
    }

    /**
     * Destroy one cookie non-existent.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testDestroyOneCookieNonExistent()
    {
        $this->assertFalse(Cookie::destroy('cookie_name'));
    }

    /**
     * Destroy all cookies.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testDestroyAllCookies()
    {
        $_COOKIE[Cookie::$prefix . 'cookie_name_one'] = 'value';
        $_COOKIE[Cookie::$prefix . 'cookie_name_two'] = 'value';

        $this->assertTrue(Cookie::destroy());
    }

    /**
     * Destroy all cookies non-existents.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     *
     * @return void
     */
    public function testDestroyAllCookiesNonExistents()
    {
        $this->assertFalse(Cookie::destroy());
    }
}
