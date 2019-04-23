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

        $this->Cookie = new Cookie();

        $cookie = $this->Cookie;

        $this->cookiePrefix = $cookie::getPrefix();
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

        $this->assertTrue($cookie::destroy());
    }

    /**
     * Destroy all cookies non-existents.
     *
     * @runInSeparateProcess
     */
    public function testDestroyAllCookiesNonExistents()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($cookie::destroy());
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

        $this->assertTrue($cookie::destroy('cookie_name'));
    }

    /**
     * Destroy one cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testDestroyOneCookieNonExistent()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($cookie::destroy('cookie_name'));
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
            $cookie::get()
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

        $this->assertFalse($cookie::get());
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

        $this->assertContains($cookie::get('cookie_name'), 'value');
    }

    /**
     * Get cookie prefix.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.6
     */
    public function testGetCookiePrefix()
    {
        $cookie = $this->Cookie;

        $this->assertContains($cookie::getPrefix(), 'jst_');
    }

    /**
     * Check if cookie exists.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.6
     */
    public function testHasCookiePrefix()
    {
        $cookie = $this->Cookie;

        $this->assertTrue($cookie::setPrefix('prefix_'));
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
     * Extract item from cookie then delete cookie and return the item.
     *
     * @runInSeparateProcess
     */
    public function testPullCookie()
    {
        $cookie = $this->Cookie;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($cookie::pull('cookie_name'), 'value');
    }

    /**
     * Extract item from cookie non-existent.
     *
     * @runInSeparateProcess
     */
    public function testPullCookieNonExistent()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($cookie::pull('cookie_name'));
    }

    /**
     * Set cookie.
     *
     * @runInSeparateProcess
     */
    public function testSetCookie()
    {
        $cookie = $this->Cookie;

        $this->assertTrue($cookie::set('cookie_name', 'value', 365));
    }

    /**
     * Set cookie prefix incorrectly.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.6
     */
    public function testSetCookieIncorrectly()
    {
        $cookie = $this->Cookie;

        $this->assertFalse($cookie::setPrefix(''));
        $this->assertFalse($cookie::setPrefix(5));
        $this->assertFalse($cookie::setPrefix(true));
    }

    /**
     * Set cookie prefix.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.6
     */
    public function testSetCookiePrefix()
    {
        $cookie = $this->Cookie;

        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertTrue($cookie::has('cookie_name'));
        $this->assertFalse($cookie::has('nulled_cookie'));
    }
}
