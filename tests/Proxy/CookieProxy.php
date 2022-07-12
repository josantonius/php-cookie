<?php

/*
 * This file is part of https://github.com/josantonius/php-cookie repository.
 *
 * (c) Josantonius <hello@josantonius.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Josantonius\Cookie\Tests\Proxy;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Josantonius\Cookie\Cookie;

class CookieProxy
{
    private CookieJar $jar;

    private array $cookies;

    private string $serverName;

    private string $serverPort;

    public function __construct(
        private string $domain = '',
        private string|int|DateTime $expires = 0,
        private bool $httpOnly = false,
        private string $path = '/',
        private bool $raw = false,
        private ?string $sameSite = null,
        private bool $secure = false,
    ) {
        $this->jar = new CookieJar();

        $this->serverName = $_SERVER['SERVER_NAME'];
        $this->serverPort = $_SERVER['SERVER_PORT'];
    }

    public function __call($method, $arguments = [])
    {
        $cookieParams = [
            'domain' => $this->domain,
            'expires' => $this->expires,
            'httpOnly' => $this->httpOnly,
            'path' => $this->path,
            'raw' => $this->raw,
            'sameSite' => $this->sameSite,
            'secure' => $this->secure,
        ];

        $cookie = new Cookie(...$cookieParams);

        if ($this->expires instanceof DateTime) {
            $cookieParams['expires'] = serialize($this->expires);
        }

        $this->getClient()->request('GET', 'callback.php', [
            'query' => array_merge([
                'method' => $method,
                'arguments' => serialize($arguments),
            ], $cookieParams),
        ]);

        $result =  call_user_func_array([$cookie, $method], $arguments);

        $this->saveCookieDetails();
        $this->setCookiesInSuperGlobal();

        return $result;
    }

    public function getCookieDetails(): array
    {
        return $this->cookies;
    }

    private function saveCookieDetails(): void
    {
        $this->cookies = $this->jar->toArray();

        foreach ($this->cookies as &$cookie) {
            if ($this->domain !== $cookie['Domain'] && $cookie['Domain'] === $this->serverName) {
                $cookie['Domain'] = $this->domain;
            }
            $cookie['Expires']  = (int) ($cookie['Expires'] ?? 0);
            $cookie['SameSite'] = $cookie['SameSite'] ?? null;
        }
    }

    private function getClient(): Client
    {
        $url = 'http://' . $this->serverName . ':' . $this->serverPort . '/callback.php';

        return new Client([
            'cookies' => $this->jar,
            'base_uri' => $url,
            'timeout'  => 2.0,
        ]);
    }

    private function setCookiesInSuperGlobal(): void
    {
        $it = $this->jar->getIterator();

        while ($it->valid()) {
            $expires = $it->current()->getExpires();
            $expired = (time() >= $expires) || $expires === 1;
            if (!$expired || $expires === null) {
                $_COOKIE[$it->current()->getName()] = $it->current()->getValue();
                $it->next();
                continue;
            }
            unset($_COOKIE[$it->current()->getName()]);
            $it->next();
        }
    }
}
