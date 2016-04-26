<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from a request header.
 */
class Header implements DeterminerInterface
{
    /**
     * Name of the header that holds the locale.
     *
     * @var string
     */
    private $header;

    /**
     * Fallback locale.
     *
     * @var string
     */
    private $fallback;

    /**
     * Constructor.
     *
     * @param  string $header   Name of the header that holds the locale
     * @param  string $fallback Fallback locale
     * @return void
     */
    public function __construct($header, $fallback)
    {
        $this->header = $header;
        $this->fallback = $fallback;
    }

    /**
     * Determine the locale from the request parameters.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function determineLocale(Request $request)
    {
        return $request->header($this->header, $this->fallback);
    }
}
