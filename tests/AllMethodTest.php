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

class AllMethodTest extends TestCase
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
    public function test_should_return_empty_array_when_there_are_no_cookies(): void
    {
        $this->assertEmpty($this->cookie->all());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_get_all_cookies(): void
    {
        $this->cookie->set('foo', 'bar');
        $this->cookie->set('bar', 'foo');

        $this->assertEquals([
            'foo' => 'bar',
            'bar' => 'foo'
        ], $this->cookie->all());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_be_available_from_the_facade(): void
    {
        $facade = new CookieFacade();

        $this->assertIsArray($facade->all());
    }
}
