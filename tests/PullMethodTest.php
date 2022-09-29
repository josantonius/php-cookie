<?php

/*
 * This file is part of https://github.com/josantonius/php-cookie repository.
 *
 * (c) Josantonius <hello@josantonius.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */

namespace Josantonius\Cookie\Tests;

use PHPUnit\Framework\TestCase;
use Josantonius\Cookie\Tests\Proxy\CookieProxy;
use Josantonius\Cookie\Exceptions\CookieException;
use Josantonius\Cookie\Facades\Cookie as CookieFacade;

class PullMethodTest extends TestCase
{
    private CookieProxy $cookie;

    public function setUp(): void
    {
        parent::setUp();

        $this->cookie = new CookieProxy();
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_pull_cookie_and_return_the_value_if_exists(): void
    {
        $this->cookie->set('foo', 'bar');
        $this->cookie->set('bar', 'foo');

        $this->assertCount(2, $this->cookie->all());

        $this->assertEquals('bar', $this->cookie->pull('foo'));
        $this->assertEquals('foo', $this->cookie->pull('bar'));

        $this->assertEmpty($this->cookie->all());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_return_default_value_if_cookie_not_exists(): void
    {
        $this->assertNull($this->cookie->pull('foo'));
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_return_custom_default_value_if_cookie_not_exists(): void
    {
        $this->assertEquals('bar', $this->cookie->pull('foo', 'bar'));
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_set_an_expiration_time_in_past(): void
    {
        $this->cookie->pull('foo', 'bar');

        $expires = $this->getCookieDetails('foo')['expires'];

        $this->assertEquals(1, $expires);
    }

    public function test_should_fail_when_headers_sent(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie->pull('foo');
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_be_available_from_the_facade(): void
    {
        $facade = new CookieFacade();

        $this->assertEquals('bar', $facade->pull('foo', 'bar'));
    }

    private function getCookieDetails(string $name): ?array
    {
        $cookies = $this->cookie->getCookieDetails();

        $key = array_search($name, array_column($cookies, 'name'));

        return isset($cookies[$key]) ? array_change_key_case($cookies[$key]) : null;
    }
}
