# Laravel Localize Middleware

> Configurable localization middleware for your Laravel 5 application.

This package provides a simple set of configuration and middleware to allow you
to automatically set your application's locale using the current request. You can
set the locale from a request parameter, the current host, a cookie or session data.

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
this functionality, just [register the provided middleware](https://laravel.com/docs/5.2/middleware#registering-middleware) in your `app/Http/Kernel.php` class:

```php
// app/Http/Kernel.php

protected $middleware = [
    \BenConstable\Localize\Http\Middleware\Localize::class
];
```

It's recommended to set this middleware globally and early in the stack, but you're
free to register in whatever way that suits you needs.

### Configuration

Configuration can be found at `config/localize-middleware.php`. From there, you
can configure which localization determiner you'd like to use in your application
and set options for it. You simply have to change the `driver` option.

The list of available determiners is shown below.

### Determining the locale from a request parameter

**Driver name:** `parameter`

The default determiner sets the application locale from a request parameter
called `locale`. You can change this using the `parameter` configuration option.

This allows you to, for example, set up your application routes like:

```php
// app/Http/routes.php

Route::group(['prefix' => '{locale}'], function () {
    // Routes here...
});
```

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

## License

MIT &copy; Ben Constable 2016. See [LICENSE](https://github.com/BenConstable/laravel-localize-middleware/blob/master/LICENSE) for more info.
