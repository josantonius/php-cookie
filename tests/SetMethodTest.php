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
use Josantonius\Cookie\Cookie;
use PHPUnit\Framework\TestCase;
use Josantonius\Cookie\Tests\Proxy\CookieProxy;
use Josantonius\Cookie\Exceptions\CookieException;
use Josantonius\Cookie\Facades\Cookie as CookieFacade;

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
    public function test_should_set_with_default_options(): void
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
    public function test_should_set_with_custom_options(): void
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
    public function test_should_set_with_custom_options_formatting_expires_from_integer(): void
    {
        $this->cookie = new CookieProxy(expires: time() + 8);

        $this->cookie->set('foo', 'bar');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_set_with_custom_options_formatting_expires_from_string(): void
    {
        $this->cookie = new CookieProxy(expires: 'now +8 seconds');

        $this->cookie->set('foo', 'bar');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_set_with_custom_options_formatting_expires_from_date_time(): void
    {
        $this->cookie = new CookieProxy(expires: new DateTime('now +8 seconds'));

        $this->cookie->set('foo', 'bar');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_set_with_expiration_time(): void
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
    public function test_should_set_replacing_global_expiration_value(): void
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
    public function test_should_set_formatting_expiration_from_string_date_time(): void
    {
        $this->cookie->set('foo', 'bar', 'now + 8 seconds');

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_set_formatting_expiration_from_integer(): void
    {
        $this->cookie->set('foo', 'bar', time() + 8);

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_set_formatting_expiration_from_date_time_object(): void
    {
        $this->cookie->set('foo', 'bar', new DateTime('now +8 seconds'));

        $details = $this->getCookieDetails('foo');

        $this->assertEquals(time() + 8, $details['expires']);
    }

    public function test_should_fail_when_parse_wrong_time_string(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie = new Cookie();

        $this->cookie->set('foo', 'bar', 'foo');
    }

    public function test_should_fail_when_headers_sent(): void
    {
        $this->expectException(CookieException::class);

        $this->cookie->set('foo', 'bar');
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_be_available_from_the_facade(): void
    {
        $facade = new CookieFacade();

        $this->assertNull(
            $facade->set('foo', 'bar')
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test_should_fail_when_expires_is_wrong(): void
    {
        $this->expectException(CookieException::class);

        $cookie = new Cookie();

        $cookie->set('foo', 'bar', 'foo');
    }

    private function getCookieDetails(string $name): array
    {
        $cookies = $this->cookie->getCookieDetails();

        $key = array_search($name, array_column($cookies, 'name'));

        return array_change_key_case($cookies[$key]);
    }
}
