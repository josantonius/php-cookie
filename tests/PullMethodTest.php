<?php

/*
 * This file is part of https://github.com/josantonius/php-cookie repository.
 *
 * (c) Josantonius <hello@josantonius.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Josantonius\Cookie\Tests;

use PHPUnit\Framework\TestCase;
use Josantonius\Cookie\Tests\Proxy\CookieProxy;
use Josantonius\Cookie\Exceptions\CookieException;
use Josantonius\Cookie\CookieFacade;

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
    public function testShouldPullCookieAndReturnTheValueIfExists(): void
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
    public function testShouldReturnDefaultValueIfCookieNotExists(): void
    {
        $this->assertNull($this->cookie->pull('foo'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldReturnCustomDefaultValueIfCookieNotExists(): void
    {
        $this->assertEquals('bar', $this->cookie->pull('foo', 'bar'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetAnExpirationTimeInPast(): void
    {
        $this->cookie->pull('foo', 'bar');

        $expires = $this->getCookieDetails('foo')['expires'];

        $this->assertEquals(1, $expires);
    }

    public function testShouldFailWhenHeadersSent(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie->pull('foo');
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBeAvailableFromTheFacade(): void
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
