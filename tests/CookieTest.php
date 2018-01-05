<?php
/**
 * PHP library for handling cookies.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2016 - 2018 (c) Josantonius - PHP-Cookie
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/Josantonius/PHP-Cookie
 * @since     1.1.3
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
     * Cookie instance.
     *
     * @since 1.1.5
     *
     * @var object
     */
    protected $Cookie;

    /**
     * Cookie prefix.
     *
     * @since 1.1.5
     *
     * @var string
     */
    protected $cookiePrefix;

    /**
     * Set up.
     *
     * @since 1.1.5
     */
    public function setUp()
    {
        parent::setUp();

        $this->Cookie = new Cookie;

        $cookie = $this->Cookie;

        $this->cookiePrefix = $Cookie::getCookiePrefix();
    }

    /**
     * Check if it is an instance of.
     *
     * @since 1.1.5
     */
    public function testIsInstanceOf()
    {
        $this->assertInstanceOf('\Josantonius\Cookie\Cookie', $this->Cookie);
    }

    /**
     * Set cookie.
     *
     * @runInSeparateProcess
     */
    public function testSetCookie()
    {
        $cookie = $this->Cookie;

        $this->assertTrue($Cookie::set('cookie_name', 'value', 365));
    }

    /**
     * Get item from cookie.
     *
     * @runInSeparateProcess
     */
    public function testGetCookie()
    {
        $cookie = $this->Cookie;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($Cookie::get('cookie_name'), 'value');
    }

    /**
     * Return cookies array.
     *
     * @runInSeparateProcess
     */
    public function testGetAllCookies()
    {
        $cookie = $this->Cookie;

        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertArrayHasKey(
            $this->cookiePrefix . 'cookie_name_two',
            $Cookie::get()
        );
    }

    /**
     * Return cookies array non-existent.
     *
     * @runInSeparateProcess
     */
    public function testGetAllCookiesNonExistents()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($Cookie::get());
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @runInSeparateProcess
     */
    public function testPullCookie()
    {
        $cookie = $this->Cookie;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($Cookie::pull('cookie_name'), 'value');
    }

    /**
     * Extract item from cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testPullCookieNonExistent()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($Cookie::pull('cookie_name'));
    }

    /**
     * Destroy one cookie.
     *
     * @runInSeparateProcess
     */
    public function testDestroyOneCookie()
    {
        $cookie = $this->Cookie;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertTrue($Cookie::destroy('cookie_name'));
    }

    /**
     * Destroy one cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testDestroyOneCookieNonExistent()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($Cookie::destroy('cookie_name'));
    }

    /**
     * Destroy all cookies.
     *
     * @runInSeparateProcess
     */
    public function testDestroyAllCookies()
    {
        $cookie = $this->Cookie;

        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertTrue($Cookie::destroy());
    }

    /**
     * Destroy all cookies non-existents.
     *
     * @runInSeparateProcess
     */
    public function testDestroyAllCookiesNonExistents()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($Cookie::destroy());
    }
}
