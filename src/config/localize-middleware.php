<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Localization Stategy.
    |--------------------------------------------------------------------------
    |
    | Set the strategy to use for localizing the application. You can pick from
    | "parameter" (the default), "host", "cookie" or "session".
    |
    */

    'driver' => 'parameter',

    /*
    |--------------------------------------------------------------------------
    | Locale Request Parameter.
    |--------------------------------------------------------------------------
    |
    | Define the name of the request parameter that will contain your
    | application's locale. Configures the "parameter" driver.
    |
    */

   'parameter' => 'locale',

   /*
    |--------------------------------------------------------------------------
    | Locale Cookie Name.
    |--------------------------------------------------------------------------
    |
    | Define the name of the cookie that will contain your application's locale.
    | Configures the "cookie" driver.
    |
    */

   'cookie' => 'locale',

   /*
    |--------------------------------------------------------------------------
    | Locale Session Key Name.
    |--------------------------------------------------------------------------
    |
    | Define the name of the session key that will contain your application's
    | locale. Configures the "session" driver.
    |
    */

   'session' => 'locale',

    /*
    |--------------------------------------------------------------------------
    | Locale/Host Mapping.
    |--------------------------------------------------------------------------
    |
    | Define a mapping of your application locales to the different hosts your
    | application will be served from. If a host doesn't match,
    | app.fallback_locale will be used. Configures the "host" driver.
    |
    */

    'hosts' => [
        'en' => 'www.example.co.uk',
        'fr' => 'www.example.fr'
    ]
];
