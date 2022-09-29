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

use DateTime;
use PHPUnit\Framework\TestCase;
use Josantonius\Cookie\Tests\Proxy\CookieProxy;
use Josantonius\Cookie\Exceptions\CookieException;
use Josantonius\Cookie\Facades\Cookie as CookieFacade;

class ReplaceMethodTest extends TestCase
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
    public function test_should_add_cookies_if_not_exist(): void
    {
        $this->cookie->replace(['foo' => 'bar']);

        $this->assertEquals([
            'foo' => 'bar',
        ], $this->cookie->all());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_replace_cookies_if_exist(): void
    {
        $this->cookie->set('foo', 'bar');
        $this->cookie->set('bar', 'foo');

        $this->cookie->replace(['foo' => 'val']);

        $this->assertEquals([
            'foo' => 'val',
            'bar' => 'foo',
        ], $this->cookie->all());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_replace_cookies_with_expiration_time(): void
    {
        $this->cookie->replace(['foo' => 'bar'], time() + 8);
        $this->cookie->replace(['bar' => 'foo'], 'now +8 seconds');
        $this->cookie->replace(['joo' => 'bar'], new DateTime('+8 seconds'));

        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'foo',
            'joo' => 'bar',
        ], $this->cookie->all());
    }

    public function test_should_fail_when_headers_sent(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie->replace(['foo' => 'bar']);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_be_available_from_the_facade(): void
    {
        $facade = new CookieFacade();

        $this->assertNull(
            $facade->replace(['foo' => 'bar'])
        );
    }
}
