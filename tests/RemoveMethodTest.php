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
    public function testShouldRemoveCookieIfExist(): void
    {
        $this->cookie->set('foo', 'bar');

        $this->cookie->remove('foo');

        $this->assertEquals([], $this->cookie->all());
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldRemoveCookieEvenIfNotExist(): void
    {
        $this->cookie->remove('foo');

        $this->assertEquals([], $this->cookie->all());
    }

    public function testShouldFailWhenHeadersSent(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie->remove('foo');
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBeAvailableFromTheFacade(): void
    {
        $facade = new CookieFacade();

        $this->assertNull(
            $facade->remove('foo')
        );
    }
}
