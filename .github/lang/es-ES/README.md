# PHP Cookie library

[![Latest Stable Version](https://poser.pugx.org/josantonius/cookie/v/stable)](https://packagist.org/packages/josantonius/cookie)
[![License](https://poser.pugx.org/josantonius/cookie/license)](LICENSE)
[![Total Downloads](https://poser.pugx.org/josantonius/cookie/downloads)](https://packagist.org/packages/josantonius/cookie)
[![CI](https://github.com/josantonius/php-cookie/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/josantonius/php-cookie/actions/workflows/ci.yml)
[![CodeCov](https://codecov.io/gh/josantonius/php-cookie/branch/master/graph/badge.svg)](https://codecov.io/gh/josantonius/php-cookie)
[![PSR1](https://img.shields.io/badge/PSR-1-f57046.svg)](https://www.php-fig.org/psr/psr-1/)
[![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](https://www.php-fig.org/psr/psr-4/)
[![PSR12](https://img.shields.io/badge/PSR-12-1abc9c.svg)](https://www.php-fig.org/psr/psr-12/)

**Traducciones**: [English](/README.md)

Biblioteca PHP para el manejo de cookies.

> La versión 1.x se considera obsoleta y sin soporte.
> En esta versión (2.x) la biblioteca fue completamente reestructurada.
> Se recomienda revisar la documentación de esta versión y hacer los cambios necesarios
> antes de empezar a utilizarla, ya que no es compatible con la versión 1.x.

---

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Métodos disponibles](#métodos-disponibles)
- [Cómo empezar](#cómo-empezar)
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

## Métodos disponibles

### Establece las opciones de las cookies

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
 */

$cookie = new Cookie(
    string              $domain   = '',
    int|string|DateTime $expires  = 0,
    bool                $httpOnly = false,
    string              $path     = '/',
    bool                $raw      = false,
    null|string         $sameSite = null,
    bool                $secure   = false
);
```

**@see** <https://www.php.net/manual/en/datetime.formats.php>
para conocer los formatos de fecha y hora admitidos.

**@throws** `CookieException` si el valor de $sameSite es incorrecto.

### Establece una cookie por nombre

```php
$cookie->set(
    string $name,
    mixed $value,
    null|int|string|DateTime $expires = null
): void
```

**@throws** `CookieException` si las cabeceras ya han sido enviadas.

**@throws** `CookieException` si falla el análisis de la cadena de fecha/hora.

### Establece varias cookies a la vez

Si las cookies existen se sustituyen, si no existen se crean.

```php
$cookie->replace(
    array $data,
    null|int|string|DateTime $expires = null
): void
```

**@throws** `CookieException` si las cabeceras ya han sido enviadas.

### Obtiene una cookie por su nombre

Opcionalmente define un valor por defecto cuando la cookie no existe.

```php
$cookie->get(string $name, mixed $default = null): mixed
```

### Obtiene todas las cookies

```php
$cookie->all(): array
```

### Comprueba si existe una cookie

```php
$cookie->has(string $name): bool
```

### Elimina una cookie por su nombre y devuelve su valor

Opcionalmente define un valor por defecto cuando la cookie no existe.

```php
$cookie->pull(string $name, mixed $default = null): mixed
```

**@throws** `CookieException` si las cabeceras ya han sido enviadas.

### Borra una cookie por su nombre

```php
$cookie->remove(string $name): void
```

**@throws** `CookieException` si las cabeceras ya han sido enviadas.

**@throws** `CookieException` si falla el análisis de la cadena de fecha/hora.

## Cómo empezar

Para utilizar esta clase con `Composer`:

```php
require __DIR__ . '/vendor/autoload.php';
```

### Utilizando objetos

```php
use Josantonius\Cookie\Cookie;

$cookie = new Cookie();
```

### Utilizando la fachada

Alternativamente puedes utilizar una fachada para acceder a los métodos estáticamente:

```php
use Josantonius\Cookie\Facades\Cookie;
```

## Usage

Ejemplos de uso de esta biblioteca:

### - Establece las opciones de las cookies

[Utilizando objetos](#using-objects):

Con opciones por defecto:

```php
$cookie = new Cookie();
```

Con opciones personalizadas:

```php
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

[Utilizando la fachada](#using-the-facade):

```php
Cookie::options(
    expires: 'now +1 hour',
    httpOnly: true,
);
```

### - Establece una cookie por nombre

[Utilizando objetos](#using-objects):

Sin modificar el tiempo de expiración:

```php
$cookie->set('foo', 'bar');
```

Modificando el tiempo de expiración:

```php
$cookie->set('foo', 'bar', time() + 3600);
```

[Utilizando la fachada](#using-the-facade):

```php
Cookie::set('foo', 'bar', new DateTime('now +1 hour'));
```

### - Establece varias cookies a la vez

[Utilizando objetos](#using-objects):

Sin modificar el tiempo de expiración:

```php
$cookie->replace(['foo' => 'bar', 'bar' => 'foo']);
```

Modificando el tiempo de expiración:

```php
$cookie->replace(['foo' => 'bar', 'bar' => 'foo'], time() + 3600);
```

[Utilizando la fachada](#using-the-facade):

```php
Cookie::replace(['foo' => 'bar', 'bar' => 'foo'], time() + 3600);
```

### - Obtiene una cookie por su nombre

[Utilizando objetos](#using-objects):

Sin valor por defecto si la cookie no existe:

```php
$cookie->get('foo'); // null si la cookie no existe
```

Con valor por defecto si la cookie no existe:

```php
$cookie->get('foo', false); // false si la cookie no existe
```

[Utilizando la fachada](#using-the-facade):

```php
Cookie::get('foo', false);
```

### - Obtiene todas las cookies

[Utilizando objetos](#using-objects):

```php
$cookie->all();
```

[Utilizando la fachada](#using-the-facade):

```php
Cookie::all();
```

### - Comprueba si existe una cookie

[Utilizando objetos](#using-objects):

```php
$cookie->has('foo');
```

[Utilizando la fachada](#using-the-facade):

```php
Cookie::has('foo');
```

### - Elimina una cookie por su nombre y devuelve su valor

[Utilizando objetos](#using-objects):

Sin valor por defecto si la cookie no existe:

```php
$cookie->pull('foo'); // null si el atributo no existe
```

Con valor por defecto si la cookie no existe:

```php
$cookie->pull('foo', false); // false si el atributo no existe
```

[Utilizando la fachada](#using-the-facade):

```php
Cookie::pull('foo', false);
```

### - Borra una cookie por su nombre

[Utilizando objetos](#using-objects):

```php
$cookie->remove('foo');
```

[Utilizando la fachada](#using-the-facade):

```php
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

Ejecutar pruebas de estándares de código [PSR2](http://www.php-fig.org/psr/psr-2/) con
[PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

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
