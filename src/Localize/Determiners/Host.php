<?php

namespace BenConstable\Localize\Determiners;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * This locale determiner fetches the locale from the request host
 * and a pre-defined mapping.
 */
class Host extends Determiner
{
    /**
     * Locale to host mapping.
     *
     * @var  \Illuminate\Support\Collection
     */
    private $hostMapping;

    /**
     * Constructor.
     *
     * @param  \Illuminate\Support\Collection  $hostMapping  Locale to host mapping
     * @return  void
     */
    public function __construct(Collection $hostMapping)
    {
        $this->hostMapping = $hostMapping;
    }

    /**
     * Determine the locale from the current host.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  string
     */
    public function determineLocale(Request $request)
    {
        return $this->hostMapping->flip()->get($request->getHost(), $this->fallback);
    }
}
