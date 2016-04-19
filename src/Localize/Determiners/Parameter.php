<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from a request parameter.
 */
class Parameter implements DeterminerInterface
{
    /**
     * Name of the request parameter that holds the locale.
     *
     * @var string
     */
    private $requestParam;

    /**
     * Fallback locale.
     *
     * @var string
     */
    private $fallback;

    /**
     * Constructor.
     *
     * @param  string $requestParam Name of the request parameter that holds the locale
     * @param  string $fallback     Fallback locale
     * @return void
     */
    public function __construct($requestParam, $fallback)
    {
        $this->requestParam = $requestParam;
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
        return $request->input($this->requestParam, $this->fallback);
    }
}
