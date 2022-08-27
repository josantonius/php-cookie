# PHP Cookie library

[![Latest Stable Version](https://poser.pugx.org/josantonius/cookie/v/stable)](https://packagist.org/packages/josantonius/cookie)
[![License](https://poser.pugx.org/josantonius/cookie/license)](LICENSE)
[![Total Downloads](https://poser.pugx.org/josantonius/cookie/downloads)](https://packagist.org/packages/josantonius/cookie)
[![CI](https://github.com/josantonius/php-cookie/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/josantonius/php-cookie/actions/workflows/ci.yml)
[![CodeCov](https://codecov.io/gh/josantonius/php-cookie/branch/main/graph/badge.svg)](https://codecov.io/gh/josantonius/php-cookie)
[![PSR1](https://img.shields.io/badge/PSR-1-f57046.svg)](https://www.php-fig.org/psr/psr-1/)
[![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](https://www.php-fig.org/psr/psr-4/)
[![PSR12](https://img.shields.io/badge/PSR-12-1abc9c.svg)](https://www.php-fig.org/psr/psr-12/)

**Traducciones**: [English](/README.md)

Biblioteca PHP para el manejo de cookies.

---

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Clases disponibles](#clases-disponibles)
  - [Clase Cookie](#clase-cookie)
  - [Fachada Cookie](#fachada-cookie)
- [Excepciones utilizadas](#excepciones-utilizadas)
- [Uso](#uso)
- [Sobre la caducidad de las cookies](#sobre-la-caducidad-de-las-cookies)
- [Tests](#tests)
- [Tareas pendientes](#tareas-pendientes)
- [Registro de Cambios](#registro-de-cambios)
- [Contribuir](#contribuir)
- [Patrocinar](#patrocinar)
- [Licencia](#licencia)

---

## Requisitos

Esta biblioteca es compatible con las versiones de PHP: 8.1.

## Instalación

La mejor forma de instalar esta extensión es a través de [Composer](http://getcomposer.org/download/).

Para instalar **PHP Cookie library**, simplemente escribe:

```console
composer require josantonius/cookie
```

El comando anterior sólo instalará los archivos necesarios,
si prefieres **descargar todo el código fuente** puedes utilizar:

```console
composer require josantonius/cookie --prefer-source
```

También puedes **clonar el repositorio** completo con Git:

```console
git clone https://github.com/josantonius/php-cookie.git
```

## Clases disponibles

### Clase Cookie

```php
use Josantonius\Cookie\Cookie;
```

Establece las opciones de las cookies:

```php
/**
 * Opciones:
 * 
 * domain:   Dominio para el que estará disponible la cookie.
 * expires:  Cuándo expirará la cookie.
 * httpOnly: Si la cookie sólo estará disponible a través del protocolo HTTP.
 * path:     Ruta para la que estará disponible la cookie.
 * raw:      Si la cookie se enviará como una cadena sin procesar.
 * sameSite: Impone el uso de una política samesite laxa o estricta.
 * secure:   Si la cookie sólo estará disponible a través del protocolo HTTPS.
 * 
 * Estos ajustes se utilizarán para crear y eliminar cookies.
 * 
 * @throws CookieException if $sameSite value is wrong.
 *
 * @see https://www.php.net/manual/en/datetime.formats.php for date formats.
 * @see https://www.php.net/manual/en/function.setcookie.php for more information.
 */

public function __construct(
    private string              $domain   = '',
    private int|string|DateTime $expires  = 0,
    private bool                $httpOnly = false,
    private string              $path     = '/',
    private bool                $raw      = false,
    private null|string         $sameSite = null,
    private bool                $secure   = false
);
```

Establece una cookie por nombre:

```php
/**
 * @throws CookieException si las cabeceras ya han sido enviadas.
 * @throws CookieException si falla el análisis de la cadena de fecha/hora.
 */
public function set(
    string $name,
    mixed $value,
    null|int|string|DateTime $expires = null
): void;
```

Establece varias cookies a la vez:

```php
/**
 * Si las cookies existen se sustituyen, si no existen se crean.
 *
 * @throws CookieException si las cabeceras ya han sido enviadas.
 */
public function replace(
    array $data,
    null|int|string|DateTime $expires = null
): void;
```

Obtiene una cookie por su nombre:

```php
/**
 * Opcionalmente define un valor por defecto cuando la cookie no existe.
 */
public function get(string $name, mixed $default = null): mixed;
```

Obtiene todas las cookies:

```php
public function all(): array;
```

Comprueba si existe una cookie:

```php
public function has(string $name): bool;
```

Elimina una cookie por su nombre y devuelve su valor:

```php
/**
 * Opcionalmente define un valor por defecto cuando la cookie no existe.
 * 
 * @throws CookieException si las cabeceras ya han sido enviadas.
 */
public function pull(string $name, mixed $default = null): mixed;
```

Borra una cookie por su nombre:

```php
/**
 * @throws CookieException si las cabeceras ya han sido enviadas.
 * @throws CookieException si falla el análisis de la cadena de fecha/hora.
 */
public function remove(string $name): void;
```

### Fachada Cookie

```php
use Josantonius\Cookie\Facades\Cookie;
```

Establece las opciones de las cookies:

```php
/**
 * Opciones:
 * 
 * domain:   Dominio para el que estará disponible la cookie.
 * expires:  Cuándo expirará la cookie.
 * httpOnly: Si la cookie sólo estará disponible a través del protocolo HTTP.
 * path:     Ruta para la que estará disponible la cookie.
 * raw:      Si la cookie se enviará como una cadena sin procesar.
 * sameSite: Impone el uso de una política samesite laxa o estricta.
 * secure:   Si la cookie sólo estará disponible a través del protocolo HTTPS.
 * 
 * Estos ajustes se utilizarán para crear y eliminar cookies.
 * 
 * @throws CookieException if $sameSite value is wrong.
 *
 * @see https://www.php.net/manual/en/datetime.formats.php for date formats.
 * @see https://www.php.net/manual/en/function.setcookie.php for more information.
 */

public static function options(
    string              $domain   = '',
    int|string|DateTime $expires  = 0,
    bool                $httpOnly = false,
    string              $path     = '/',
    bool                $raw      = false,
    null|string         $sameSite = null,
    bool                $secure   = false
): void;
```

Establece una cookie por nombre:

```php
/**
 * @throws CookieException si las cabeceras ya han sido enviadas.
 * @throws CookieException si falla el análisis de la cadena de fecha/hora.
 */
public static function set(
    string $name,
    mixed $value,
    null|int|string|DateTime $expires = null
): void;
```

Establece varias cookies a la vez:

```php
/**
 * Si las cookies existen se sustituyen, si no existen se crean.
 *
 * @throws CookieException si las cabeceras ya han sido enviadas.
 */
public static function replace(
    array $data,
    null|int|string|DateTime $expires = null
): void;
```

Obtiene una cookie por su nombre:

```php
/**
 * Opcionalmente define un valor por defecto cuando la cookie no existe.
 */
public static function get(string $name, mixed $default = null): mixed;
```

Obtiene todas las cookies:

```php
public static function all(): array;
```

Comprueba si existe una cookie:

```php
public static function has(string $name): bool;
```

Elimina una cookie por su nombre y devuelve su valor:

```php
/**
 * Opcionalmente define un valor por defecto cuando la cookie no existe.
 * 
 * @throws CookieException si las cabeceras ya han sido enviadas.
 */
public static function pull(string $name, mixed $default = null): mixed;
```

Borra una cookie por su nombre:

```php
/**
 * @throws CookieException si las cabeceras ya han sido enviadas.
 * @throws CookieException si falla el análisis de la cadena de fecha/hora.
 */
public static function remove(string $name): void;
```

## Excepciones utilizadas

```php
use Josantonius\Cookie\Exceptions\CookieException;
```

## Usage

Ejemplos de uso de esta biblioteca:

### Crear una instancia de Cookie con opciones por defecto

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::options();
```

### Crear una instancia de Cookie con opciones personalizadas

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie(
    domain: 'example.com',
    expires: time() + 3600,
    httpOnly: true,
    path: '/foo',
    raw: true,
    sameSite: 'Strict',
    secure: true,
);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::options(
    expires: 'now +1 hour',
    httpOnly: true,
);
```

### Establece una cookie por nombre

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->set('foo', 'bar');
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::set('foo', 'bar');
```

### Establece una cookie por nombre modificando el tiempo de caducidad

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->set('foo', 'bar', time() + 3600);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::set('foo', 'bar', new DateTime('now +1 hour'));
```

### Establece varias cookies a la vez

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->replace([
    'foo' => 'bar',
    'bar' => 'foo'
]);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::replace([
    'foo' => 'bar',
    'bar' => 'foo'
], time() + 3600);
```

### Establece varias cookies a la vez modificando el tiempo de caducidad

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->replace([
    'foo' => 'bar',
    'bar' => 'foo'
], time() + 3600);
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::replace([
    'foo' => 'bar',
    'bar' => 'foo'
], time() + 3600);
```

### Obtiene una cookie por su nombre

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->get('foo'); // null si la cookie no existe
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::get('foo'); // null si la cookie no existe
```

### Obtiene una cookie por su nombre con valor por defecto si la cookie no existe

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->get('foo', false); // false si la cookie no existe
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::get('foo', false); // false si la cookie no existe
```

### Obtiene todas las cookies

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->all();
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::all();
```

### Comprueba si existe una cookie

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->has('foo');
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::has('foo');
```

### Elimina una cookie por su nombre y devuelve su valor

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->pull('foo'); // null si el atributo no existe
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::pull('foo'); // null si el atributo no existe
```

### Elimina una cookie y devuelve su valor o el valor por defecto no existe

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->pull('foo', false); // false si el atributo no existe
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::pull('foo', false); // false si el atributo no existe
```

### Borra una cookie por su nombre

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();

$cookie->remove('foo');
```

```php
use Josantonius\Cookie\Facades\Cookie;

Cookie::remove('foo');
```

## Sobre la caducidad de las cookies

- El parámetro **expires** utilizado en varios métodos de esta biblioteca acepta los siguientes tipos:
`int|string|DateTime`.

  - `Enteros` se manejarán como tiempo en unix excepto el cero.
  - `Cadenas` se manejarán como formatos de fecha/hora.
  Ver [Formatos de fecha y hora](https://www.php.net/manual/en/datetime.formats.php) soportados
  para más información.

    ```php
    $cookie = new Cookie(
        expires: '2016-12-15 +1 day'
    );
    ```

    Sería similar a:

    ```php
    $cookie = new Cookie(
        expires: new DateTime('2016-12-15 +1 day')
    );
    ```

  - Los objetos `DateTime` serán utilizados para obtener el tiempo en unix.

- Si el parámetro **expires** se utiliza en los métodos `set` o `replace`,
se utilizará este en lugar del valor de **_expires_** establecido en las opciones de la cookie.

    ```php
    $cookie = new Cookie(
        expires: 'now +1 minute'
    );

    $cookie->set('foo', 'bar');                        // Caduca en 1 minuto

    $cookie->set('bar', 'foo', 'now +8 days');         // Caduca en 8 días

    $cookie->replace(['foo' => 'bar']);                // Caduca en 1 minuto

    $cookie->replace(['foo' => 'bar'], time() + 3600); // Caduca en 1 hora
    ```

- Si el parámetro **expires** pasado en las opciones es una cadena de fecha/hora,
se formateará cuando se utiliza el método `set` o `replace` y no cuando se establecen las opciones.

    ```php
    $cookie = new Cookie(
        expires: 'now +1 minute', // Todavía no se formateará como tiempo unix
    );

    $cookie->set('foo', 'bar');   // Se formateará ahora y expirará en 1 minuto
    ```

## Tests

Para ejecutar las [pruebas](tests) necesitarás [Composer](http://getcomposer.org/download/)
y seguir los siguientes pasos:

```console
git clone https://github.com/josantonius/php-cookie.git
```

```console
cd php-cookie
```

```console
composer install
```

Ejecutar pruebas unitarias con [PHPUnit](https://phpunit.de/):

```console
composer phpunit
```

Ejecutar pruebas de estándares de código con [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

```console
composer phpcs
```

Ejecutar pruebas con [PHP Mess Detector](https://phpmd.org/) para detectar inconsistencias
en el estilo de codificación:

```console
composer phpmd
```

Ejecutar todas las pruebas anteriores:

```console
composer tests
```

## Tareas pendientes

- [ ] Añadir nueva funcionalidad
- [ ] Mejorar pruebas
- [ ] Mejorar documentación
- [ ] Mejorar la traducción al inglés en el archivo README
- [ ] Refactorizar código para las reglas de estilo de código deshabilitadas
(ver [phpmd.xml](phpmd.xml) y [phpcs.xml](phpcs.xml))

## Registro de Cambios

Los cambios detallados de cada versión se documentan en las
[notas de la misma](https://github.com/josantonius/php-cookie/releases).

## Contribuir

Por favor, asegúrate de leer la [Guía de contribución](CONTRIBUTING.md) antes de hacer un
_pull request_, comenzar una discusión o reportar un _issue_.

¡Gracias por [colaborar](https://github.com/josantonius/php-cookie/graphs/contributors)! :heart:

## Patrocinar

Si este proyecto te ayuda a reducir el tiempo de desarrollo,
[puedes patrocinarme](https://github.com/josantonius/lang/es-ES/README.md#patrocinar)
para apoyar mi trabajo :blush:

## Licencia

Este repositorio tiene una licencia [MIT License](LICENSE).

Copyright © 2016-actualidad, [Josantonius](https://github.com/josantonius/lang/es-ES/README.md#contacto)
