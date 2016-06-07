<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from the session.
 */
class Session extends Determiner
{
    /**
     * Name of the session key that holds the locale.
     *
     * @var  string
     */
    private $sessionKey;

    /**
     * Constructor.
     *
     * @param  string  $sessionKey  Name of the session key that holds the locale
     * @return  void
     */
    public function __construct($sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }

    /**
     * Determine the locale from the session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  string
     */
    public function determineLocale(Request $request)
    {
        return $request->session()->get($this->sessionKey, $this->fallback);
    }
}
