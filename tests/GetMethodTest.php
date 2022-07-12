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
use Josantonius\Cookie\CookieFacade;

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
    public function testShouldReturnValueWhenCookieExists(): void
    {
        $this->cookie->set('foo', 'bar');

        $this->assertEquals('bar', $this->cookie->get('foo'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldReturnDefaultValueWhenCookieNotExists(): void
    {
        $this->assertNull($this->cookie->get('foo'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldReturnCustomDefaultValueWhenCookieNotExists(): void
    {
        $this->assertEquals('bar', $this->cookie->get('foo', 'bar'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBeAvailableFromTheFacade(): void
    {
        $facade = new CookieFacade();

        $this->assertNull($facade->get('foo'));
    }
}