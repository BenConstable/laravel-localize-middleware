<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from a cookie.
 */
class Cookie extends Determiner
{
    /**
     * Name of the cookie that holds the locale.
     *
     * @var string
     */
    private $cookieName;

    /**
     * Constructor.
     *
     * @param  string $cookieName Name of the cookie that holds the locale
     * @return void
     */
    public function __construct($cookieName)
    {
        $this->cookieName = $cookieName;
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
