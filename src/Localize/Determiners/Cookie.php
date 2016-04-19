<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from a cookie.
 */
class Cookie implements DeterminerInterface
{
    /**
     * Name of the cookie that holds the locale.
     *
     * @var string
     */
    private $cookieName;

    /**
     * Fallback locale.
     *
     * @var string
     */
    private $fallback;

    /**
     * Constructor.
     *
     * @param  string $cookieName Name of the cookie that holds the locale
     * @param  string $fallback   Fallback locale
     * @return void
     */
    public function __construct($cookieName, $fallback)
    {
        $this->cookieName = $cookieName;
        $this->fallback = $fallback;
    }

    /**
     * Determine the locale from a cookie.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function determineLocale(Request $request)
    {
        return $request->cookie($this->cookieName, $this->fallback);
    }
}
