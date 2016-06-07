<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from a request header.
 */
class Header extends Determiner
{
    /**
     * Name of the header that holds the locale.
     *
     * @var string
     */
    private $header;

    /**
     * Constructor.
     *
     * @param  string $header Name of the header that holds the locale
     * @return void
     */
    public function __construct($header)
    {
        $this->header = $header;
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
