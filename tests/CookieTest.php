<?php
/**
 * PHP library for handling cookies.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2016 - 2017 (c) Josantonius - PHP-Cookie
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
        $this->cookiePrefix = $this->Cookie->getCookiePrefix();
    }

    /**
     * Check if it is an instance of Algorithm.
     *
     * @since 1.1.5
     */
    public function testIsInstanceOfCookie()
    {
        $actual = $this->Cookie;
        $this->assertInstanceOf('\Josantonius\Cookie\Cookie', $actual);
    }

    /**
     * Set cookie.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testSetCookie()
    {
        $this->assertTrue($this->Cookie->set('cookie_name', 'value', 365));
    }

    /**
     * Get item from cookie.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testGetCookie()
    {
        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($this->Cookie->get('cookie_name'), 'value');
    }

    /**
     * Return cookies array.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testGetAllCookies()
    {
        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertArrayHasKey(
            $this->cookiePrefix . 'cookie_name_two',
            $this->Cookie->get()
        );
    }

    /**
     * Return cookies array non-existent.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testGetAllCookiesNonExistents()
    {
        $this->assertFalse($this->Cookie->get());
    }

    /**
     * Extract item from cookie then delete cookie and return the item.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testPullCookie()
    {
        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertContains($this->Cookie->pull('cookie_name'), 'value');
    }

    /**
     * Extract item from cookie non-existent.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testPullCookieNonExistent()
    {
        $this->assertFalse($this->Cookie->pull('cookie_name'));
    }

    /**
     * Destroy one cookie.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testDestroyOneCookie()
    {
        $_COOKIE[$this->cookiePrefix . 'cookie_name'] = 'value';

        $this->assertTrue($this->Cookie->destroy('cookie_name'));
    }

    /**
     * Destroy one cookie non-existent.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testDestroyOneCookieNonExistent()
    {
        $this->assertFalse($this->Cookie->destroy('cookie_name'));
    }

    /**
     * Destroy all cookies.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testDestroyAllCookies()
    {
        $_COOKIE[$this->cookiePrefix . 'cookie_name_one'] = 'value';
        $_COOKIE[$this->cookiePrefix . 'cookie_name_two'] = 'value';

        $this->assertTrue($this->Cookie->destroy());
    }

    /**
     * Destroy all cookies non-existents.
     *
     * @runInSeparateProcess
     *
     * @since 1.1.3
     */
    public function testDestroyAllCookiesNonExistents()
    {
        $this->assertFalse($this->Cookie->destroy());
    }
}
