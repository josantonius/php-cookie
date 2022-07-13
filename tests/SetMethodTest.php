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

use DateTime;
use Josantonius\Cookie\Cookie;
use PHPUnit\Framework\TestCase;
use Josantonius\Cookie\Tests\Proxy\CookieProxy;
use Josantonius\Cookie\Exceptions\CookieException;
use Josantonius\Cookie\CookieFacade;

class SetMethodTest extends TestCase
{
    private CookieProxy|Cookie $cookie;

    public function setUp(): void
    {
        parent::setUp();

        $this->cookie = new CookieProxy();
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieWithDefaultOptions(): void
    {
        $this->cookie->set('foo', 'bar');

        $this->assertEquals('bar', $this->cookie->get('foo'));

        $details = $this->getCookieDetails('foo');

        $this->assertEquals('', $details['domain']);
        $this->assertEquals(0, $details['expires']);
        $this->assertEquals(false, $details['httponly']);
        $this->assertEquals('foo', $details['name']);
        $this->assertEquals('/', $details['path']);
        $this->assertEquals(null, $details['samesite']);
        $this->assertEquals(false, $details['secure']);
        $this->assertEquals('bar', $details['value']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieWithCustomOptions(): void
    {
        $this->cookie = new CookieProxy(
            domain: 'localhost',
            expires: time() + 8,
            httpOnly: true,
            path: '/foo',
            raw: true,
            sameSite: 'Lax',
            secure: true,
        );

        $this->cookie->set('foo', 'bar');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals('localhost', $details['domain']);
        $this->assertEquals(time() + 8, $details['expires']);
        $this->assertEquals(true, $details['httponly']);
        $this->assertEquals('foo', $details['name']);
        $this->assertEquals('/foo', $details['path']);
        $this->assertEquals('Lax', $details['samesite']);
        $this->assertEquals(true, $details['secure']);
        $this->assertEquals('bar', $details['value']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieWithCustomOptionsFormattingExpiresFromInteger(): void
    {
        $this->cookie = new CookieProxy(expires: time() + 8);

        $this->cookie->set('foo', 'bar');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieWithCustomOptionsFormattingExpiresFromString(): void
    {
        $this->cookie = new CookieProxy(expires: 'now +8 seconds');

        $this->cookie->set('foo', 'bar');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieWithCustomOptionsFormattingExpiresFromDateTime(): void
    {
        $this->cookie = new CookieProxy(expires: new DateTime('now +8 seconds'));

        $this->cookie->set('foo', 'bar');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieWithExpirationTime(): void
    {
        $this->cookie->set('foo', 'bar', time() + 8);

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
        $this->assertEquals('foo', $details['name']);
        $this->assertEquals('bar', $details['value']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieReplacingGlobalExpirationValueWhenNewOneIsPassed(): void
    {
        $this->cookie = new CookieProxy(expires: 'now +8 seconds');

        $this->cookie->set('foo', 'bar', time() + 80);

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 80, $details['expires']);
        $this->assertEquals('foo', $details['name']);
        $this->assertEquals('bar', $details['value']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieFormattingExpirationFromStringDateTime(): void
    {
        $this->cookie->set('foo', 'bar', 'now + 8 seconds');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieFormattingExpirationFromInteger(): void
    {
        $this->cookie->set('foo', 'bar', time() + 8);

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldSetCookieFormattingExpirationFromDateTimeObject(): void
    {
        $this->cookie->set('foo', 'bar', new DateTime('now +8 seconds'));

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    public function testShouldFailWhenParseWrongTimeString(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie = new Cookie();

        $this->cookie->set('foo', 'bar', 'foo');
    }

    public function testShouldFailWhenHeadersSent(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie->set('foo', 'bar');
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBeAvailableFromTheFacade(): void
    {
        $facade = new CookieFacade();

        $this->assertNull(
            $facade->set('foo', 'bar')
        );
    }

    private function getCookieDetails(string $name): array
    {
        $cookies = $this->cookie->getCookieDetails();

        $key = array_search($name, array_column($cookies, 'name'));

        return array_change_key_case($cookies[$key]);
    }
}
