<?php

/*
 * This file is part of https://github.com/josantonius/php-cookie repository.
 *
 * (c) Josantonius <hello@josantonius.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Josantonius\Cookie\Exceptions;

use Throwable;

/**
 * Cookie exception manager.
 */
class CookieException extends \Exception
{
    public function __construct(string $message = 'Unknown error', Throwable|null $previous = null)
    {
        parent::__construct(rtrim($message, '.') . '.', 0, $previous);
    }
}
