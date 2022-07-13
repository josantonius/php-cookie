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
use Josantonius\Cookie\Facades\Cookie as CookieFacade;

class OptionsMethodTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testShouldBehaveSameAsConstructorWithDefaultValues(): void
    {
        $facade = new CookieFacade();

        $this->assertNull(
            $facade->options()
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBehaveSameAsConstructorWithCustomValues(): void
    {
        $facade = new CookieFacade();

        $this->assertNull(
            $facade->options(
                domain: 'example.com',
                expires: 8,
                httpOnly: true,
                path: '/foo',
                raw: true,
                sameSite: 'Strict',
                secure: true,
            )
        );
    }
}
