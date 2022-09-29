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
use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Josantonius\Cookie\Cookie;
use Josantonius\Cookie\Exceptions\CookieException;

class ConstructorTest extends TestCase
{
    private Cookie $cookie;

    public function setUp(): void
    {
        parent::setUp();

        $this->cookie = new Cookie();
    }

    public function test_should_create_instance_with_default_values(): void
    {
        $cookie = new Cookie();

        $this->assertInstanceOf(Cookie::class, $cookie);

        $this->assertEquals($this->getPrivateProperty($cookie, 'domain'), '');
        $this->assertEquals($this->getPrivateProperty($cookie, 'expires'), 0);
        $this->assertEquals($this->getPrivateProperty($cookie, 'httpOnly'), false);
        $this->assertEquals($this->getPrivateProperty($cookie, 'path'), '/');
        $this->assertEquals($this->getPrivateProperty($cookie, 'raw'), false);
        $this->assertEquals($this->getPrivateProperty($cookie, 'sameSite'), null);
        $this->assertEquals($this->getPrivateProperty($cookie, 'secure'), false);
    }

    public function test_should_create_instance_with_custom_values(): void
    {
        $cookie = new Cookie(
            domain: 'example.com',
            expires: time() + 8,
            httpOnly: true,
            path: '/foo',
            raw: true,
            sameSite: 'Strict',
            secure: true,
        );

        $this->assertInstanceOf(Cookie::class, $cookie);

        $this->assertEquals($this->getPrivateProperty($cookie, 'domain'), 'example.com');
        $this->assertEquals($this->getPrivateProperty($cookie, 'expires'), time() + 8);
        $this->assertEquals($this->getPrivateProperty($cookie, 'httpOnly'), true);
        $this->assertEquals($this->getPrivateProperty($cookie, 'path'), '/foo');
        $this->assertEquals($this->getPrivateProperty($cookie, 'raw'), true);
        $this->assertEquals($this->getPrivateProperty($cookie, 'sameSite'), 'Strict');
        $this->assertEquals($this->getPrivateProperty($cookie, 'secure'), true);
    }

    public function test_should_fail_if_same_site_value_is_wrong(): void
    {
        $this->expectException(CookieException::class);

        new Cookie(sameSite: 'Foo');
    }

    private function getPrivateProperty(Cookie $object, string $property): mixed
    {
        $reflection = new ReflectionClass($object);

        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($object);
    }
}
