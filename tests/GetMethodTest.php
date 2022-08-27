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
use Josantonius\Cookie\Facades\Cookie as CookieFacade;

class GetMethodTest extends TestCase
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
    public function test_should_return_value_when_cookie_exists(): void
    {
        $this->cookie->set('foo', 'bar');

        $this->assertEquals('bar', $this->cookie->get('foo'));
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_return_default_value_when_cookie_not_exists(): void
    {
        $this->assertNull($this->cookie->get('foo'));
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_return_custom_default_value_when_cookie_not_exists(): void
    {
        $this->assertEquals('bar', $this->cookie->get('foo', 'bar'));
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_be_available_from_the_facade(): void
    {
        $facade = new CookieFacade();

        $this->assertNull($facade->get('foo'));
    }
}
