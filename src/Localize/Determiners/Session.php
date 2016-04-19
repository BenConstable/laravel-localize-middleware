<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from the session.
 */
class Session implements DeterminerInterface
{
    /**
     * Name of the session key that holds the locale.
     *
     * @var string
     */
    private $sessionKey;

    /**
     * Fallback locale.
     *
     * @var string
     */
    private $fallback;

    /**
     * Constructor.
     *
     * @param  string $sessionKey Name of the session key that holds the locale
     * @param  string $fallback   Fallback locale
     * @return void
     */
    public function __construct($sessionKey, $fallback)
    {
        $this->sessionKey = $sessionKey;
        $this->fallback = $fallback;
    }

    /**
     * Determine the locale from the session.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function determineLocale(Request $request)
    {
        return $request->session()->get($this->sessionKey, $this->fallback);
    }
}
