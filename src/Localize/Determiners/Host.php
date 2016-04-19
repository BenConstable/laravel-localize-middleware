<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * This locale determiner fetches the locale from the request host
 * and a pre-defined mapping.
 */
class Host implements DeterminerInterface
{
    /**
     * Locale to host mapping.
     *
     * @var \Illuminate\Support\Collection
     */
    private $hostMapping;

    /**
     * Fallback locale.
     *
     * @var string
     */
    private $fallback;

    /**
     * Constructor.
     *
     * @param  \Illuminate\Support\Collection $hostMapping Locale to host mapping
     * @param  string                         $fallback    Fallback locale
     * @return void
     */
    public function __construct(Collection $hostMapping, $fallback)
    {
        $this->hostMapping = $hostMapping;
        $this->fallback = $fallback;
    }

    /**
     * Determine the locale from the current host.
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function determineLocale(Request $request)
    {
        return $this->hostMapping->flip()->get($request->getHost(), $this->fallback);
    }
}
