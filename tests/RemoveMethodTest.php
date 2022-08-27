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

class RemoveMethodTest extends TestCase
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
    public function test_should_remove_cookie_if_exist(): void
    {
        $this->cookie->set('foo', 'bar');

        $this->cookie->remove('foo');

        $this->assertEquals([], $this->cookie->all());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_remove_cookie_even_if_not_exist(): void
    {
        $this->cookie->remove('foo');

        $this->assertEquals([], $this->cookie->all());
    }

    public function test_should_fail_when_headers_sent(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie->remove('foo');
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_be_available_from_the_facade(): void
    {
        $facade = new CookieFacade();

        $this->assertNull(
            $facade->remove('foo')
        );
    }
}
