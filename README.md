# Laravel Localize Middleware

> Configurable localization middleware for your Laravel >=5.1 application.

[![Build Status](https://travis-ci.org/BenConstable/laravel-localize-middleware.svg?branch=master)](https://travis-ci.org/BenConstable/laravel-localize-middleware)
[![Latest Stable Version](https://poser.pugx.org/benconstable/laravel-localize-middleware/v/stable)](https://packagist.org/packages/benconstable/laravel-localize-middleware)
[![License](https://poser.pugx.org/benconstable/laravel-localize-middleware/license)](https://packagist.org/packages/benconstable/laravel-localize-middleware)

This package provides a simple set of configuration and middleware to allow you
to automatically set your application's locale using the current request. You can
set the locale from a request parameter, header, the current host, a cookie or
session data.

## Installation

Install the package via Composer:

```
$ composer require benconstable/laravel-localize-middleware
```

Next, add the package's service provider to your `config/app.php`:

```php
// config/app.php

'providers' => [
    BenConstable\Localize\LocalizeServiceProvider::class
]
```

and then you'll just need to publish the package's configuration:

```
$ php artisan vendor:publish --provider="BenConstable\Localize\LocalizeServiceProvider"
```

which will create `config/localize-middleware.php`.

## Usage

Out-of-the-box, the package is configured to set the application locale using a
request parameter called `locale` (see the next section for more info). To enable
this functionality, just [register the provided middleware](https://laravel.com/docs/5.4/middleware#registering-middleware) in your `app/Http/Kernel.php` class:

```php
// app/Http/Kernel.php

protected $middleware = [
    \BenConstable\Localize\Http\Middleware\Localize::class
];
```

It's recommended to set this middleware globally and early in the stack, but you're
free to register it in whatever way that suits your needs.

### Configuration

Configuration can be found at `config/localize-middleware.php`. From there, you
can configure which localization determiner you'd like to use in your application
and set options for it. You simply have to change the `driver` option.

The list of available determiners is shown below.

### Determining the locale from a request parameter

**Driver name:** `parameter`

The default determiner sets the application locale from a request parameter
called `locale`. You can change this using the `parameter` configuration option.

The parameter will be discovered in the query string of request body.

### Determining the locale from a request header

**Driver name:** `header`

This determiner sets the application locale from a request header, which defaults
to `Accept-Language`. You can change this using the `header` configuration option.

*Aside:* For information on using `Accept-Language` to determine the locale,
see [this info from the W3C](https://www.w3.org/International/questions/qa-accept-lang-locales).

### Determining the locale using the current host

**Driver name:** `host`

This determiner sets a different application locale depending on the current host.
You'll need to set a map of your application's locales to hosts using the `hosts`
configuration option.

### Determining the locale from a cookie

**Driver name:** `cookie`

This determiner sets the application locale from a cookie called `locale`. You can
change this using the `cookie` configuration option.

### Determining the locale from the session

**Driver name:** `session`

This determiner sets the application locale from a session value called `locale`.
You can change this using the `session` configuration option.

### Using multiple determiners

Sometimes it might be useful to try and determine the locale from more than one
source. If you'd like to do this, just set the `driver` configuration option to an
array of other driver names. For example:

```php
'driver' => [
    'cookie',
    'parameter'
]
```

The locale will then be deteremined from whichever determiner first provides a
successful match, so make sure you add the drivers in the correct order (earliest
in the array will be used first).

### Determining the locale outside of middleware

You don't have to use the provided middleware if you don't want to. You can
instead write your own, or avoid using middleware entirely.

To determine the locale in your own code, first register an alias for the provided
facade (which is actually a reference to `BenConstable\Localize\DeterminerManager`, if
you want to inject it).

```php
// config/app.php

'aliases' => [
    'Localizer' => BenConstable\Localize\DeterminerFacade::class
]
```

Then, you can just do:

```php
$locale = Localizer::determineLocale($request);
```

to determine the locale and do with it what you like.

## Contributing

See [CONTRIBUTING.md](https://github.com/BenConstable/laravel-localize-middleware/blob/master/CONTRIBUTING.md).

## Other Localization Projects

Here are some other Laravel localization projects that might be useful to you:

* [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)
* [Waavi/translation](https://github.com/Waavi/translation)
* [caouecs/Laravel-lang](https://github.com/caouecs/Laravel-lang)

## License

MIT &copy; Ben Constable 2017. See [LICENSE](https://github.com/BenConstable/laravel-localize-middleware/blob/master/LICENSE) for more info.
