<?php

/*
 * This file is part of https://github.com/josantonius/php-cookie repository.
 *
 * (c) Josantonius <hello@josantonius.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require '../../vendor/autoload.php';

use Josantonius\Cookie\Cookie;

if (($unserialize = unserialize($_GET['expires'])) !== false) {
    $_GET['expires'] = $unserialize;
}

$cookie = new Cookie(
    domain: $_GET['domain'],
    expires: is_numeric($_GET['expires']) ? (int) $_GET['expires'] : $_GET['expires'],
    httpOnly: (bool) $_GET['httpOnly'],
    path: $_GET['path'],
    raw: (bool) $_GET['raw'],
    sameSite: $_GET['sameSite'] ?? null,
    secure: (bool) $_GET['secure'],
);

$method    = $_GET['method'];
$arguments = unserialize($_GET['arguments']);

echo json_encode(call_user_func_array([$cookie, $method], $arguments));
