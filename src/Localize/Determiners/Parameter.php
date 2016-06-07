<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;

/**
 * This locale determiner fetches the locale from a request parameter.
 */
class Parameter extends Determiner
{
    /**
     * Name of the request parameter that holds the locale.
     *
     * @var string
     */
    private $requestParam;

    /**
     * Constructor.
     *
     * @param  string  $requestParam  Name of the request parameter that holds the locale
     * @return  void
     */
    public function __construct($requestParam)
    {
        $this->requestParam = $requestParam;
    }

    /**
     * Determine the locale from the request parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  string
     */
    public function determineLocale(Request $request)
    {
        return $request->input($this->requestParam, $this->fallback);
    }
}
